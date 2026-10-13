#!/usr/bin/env node

/**
 * Intellibook AI CLI
 * Official command-line utility for https://www.intellibookai.com
 */

const BASE_URL = process.env.INTELLIBOOK_URL || "https://www.intellibookai.com";

const args = process.argv.slice(2);
const command = args[0] || "help";

function showHelp() {
  console.log(`
  ✨ Intellibook AI CLI v1.0.0
  The Autonomous WhatsApp AI Receptionist & Booking System for India

  Website:  https://www.intellibookai.com
  API Docs: https://www.intellibookai.com/docs
  MCP Docs: https://www.intellibookai.com/docs#mcp

  USAGE:
    npx intellibook-ai <command> [options]

  COMMANDS:
    search <query> [--city <name>]  Search registered businesses (salons, clinics, spas)
    slots <businessId>             Check available appointment slots
    mcp                            Display MCP configuration snippet for Claude & Cursor
    gbp <businessName> [city]      Trigger Google Business Profile AI audit
    version                        Show version
    help                           Show this help message

  EXAMPLES:
    npx intellibook-ai search "dental" --city Bangalore
    npx intellibook-ai slots 1
    npx intellibook-ai mcp
`);
}

async function search(query, city) {
  if (!query) {
    console.error("Error: Please provide a search term. Example: intellibook search 'salon'");
    process.exit(1);
  }
  const url = new URL(`${BASE_URL}/api/v1/search`);
  url.searchParams.set("q", query);
  if (city) url.searchParams.set("city", city);

  try {
    const res = await fetch(url.toString());
    const data = await res.json();
    console.log(`\n🔍 Search results for "${query}"${city ? ` in ${city}` : ""}:\n`);
    if (!data.businesses || data.businesses.length === 0) {
      console.log("  No businesses found matching your criteria.");
      console.log(`  Explore more at: ${BASE_URL}/find\n`);
      return;
    }
    data.businesses.forEach((b) => {
      console.log(`  • [ID: ${b.id}] ${b.name} (${b.type || "Service"})`);
      if (b.address) console.log(`    Address: ${b.address}`);
      if (b.rating) console.log(`    Rating: ⭐ ${b.rating}`);
      console.log(`    Book online: ${BASE_URL}/b/${b.slug || b.id}\n`);
    });
  } catch (err) {
    console.error("Failed to connect to Intellibook AI:", err.message);
  }
}

async function slots(businessId) {
  if (!businessId) {
    console.error("Error: Please provide a business ID. Example: intellibook slots 1");
    process.exit(1);
  }
  try {
    const res = await fetch(`${BASE_URL}/api/v1/slots/${businessId}`);
    const data = await res.json();
    console.log(`\n📅 Available slots for Business #${businessId}:\n`);
    if (!data.slots || data.slots.length === 0) {
      console.log("  No open slots available today.");
      console.log(`  Join waitlist or view online schedule: ${BASE_URL}/b/${businessId}\n`);
      return;
    }
    data.slots.forEach((s) => {
      console.log(`  • ${s.startTime} - ${s.endTime} (${s.available ? "Available" : "Booked"})`);
    });
    console.log("");
  } catch (err) {
    console.error("Failed to fetch slots:", err.message);
  }
}

function showMcp() {
  console.log(`
  🔌 Intellibook AI Model Context Protocol (MCP) Server

  Endpoint (Streamable HTTP):
    https://www.intellibookai.com/mcp

  Add to Claude Desktop (claude_desktop_config.json) or Cursor:
  {
    "mcpServers": {
      "intellibook-ai": {
        "type": "http",
        "url": "https://www.intellibookai.com/mcp"
      }
    }
  }

  For full MCP documentation and tools, visit:
  https://www.intellibookai.com/docs#mcp
`);
}

async function gbp(name, city) {
  if (!name) {
    console.error("Error: Please provide business name. Example: intellibook gbp 'Glow Salon' Bangalore");
    process.exit(1);
  }
  console.log(`\n📊 Initiating Google Business Profile AI Audit for "${name}"${city ? ` (${city})` : ""}...`);
  try {
    const res = await fetch(`${BASE_URL}/api/v1/seo-audit`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ businessName: name, city: city || "" }),
    });
    const data = await res.json();
    if (!res.ok) {
      console.error(`  Audit failed (${res.status}): ${data.error || "unknown error"}`);
      return;
    }
    console.log("  Audit status: Complete");
    if (data.businessName) console.log(`  Matched business: ${data.businessName}${data.address ? ` (${data.address})` : ""}`);
    if (data.overallScore != null) console.log(`  Overall score: ${data.overallScore}/100`);
    if (data.localSeoScore != null) console.log(`  Local SEO score: ${data.localSeoScore}/100`);
    console.log(`  Full report available at: ${BASE_URL}/google-business-profile-seo\n`);
  } catch (err) {
    console.error("Audit request failed:", err.message);
  }
}

// Router
if (command === "search") {
  const query = args[1];
  const cityIdx = args.indexOf("--city");
  const city = cityIdx !== -1 ? args[cityIdx + 1] : undefined;
  search(query, city);
} else if (command === "slots") {
  slots(args[1]);
} else if (command === "mcp") {
  showMcp();
} else if (command === "gbp") {
  gbp(args[1], args[2]);
} else if (command === "version" || command === "-v" || command === "--version") {
  console.log("1.0.0");
} else {
  showHelp();
}
