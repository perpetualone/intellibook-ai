# intellibook-ai

[![npm version](https://img.shields.io/npm/v/intellibook-ai.svg)](https://www.npmjs.com/package/intellibook-ai)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Official CLI and developer toolkit for [Intellibook AI](https://www.intellibookai.com) — the 24/7 Autonomous WhatsApp AI Receptionist & Appointment Booking Automation platform designed specifically for salons, medical clinics, aesthetic centres, and wellness spas across India.

Learn more at [https://www.intellibookai.com](https://www.intellibookai.com).

---

## ⚡ Quick Start

Run directly with `npx` (no installation required):

```bash
# Search businesses listed on Intellibook
npx intellibook-ai search "dental" --city Bangalore

# Check available appointment slots for a business
npx intellibook-ai slots 1

# View MCP (Model Context Protocol) connection details
npx intellibook-ai mcp

# Run Google Business Profile & Local SEO AI Audit
npx intellibook-ai gbp "Aura Wellness Spa" "Indiranagar, Bangalore"
```

Or install globally:

```bash
npm install -g intellibook-ai
intellibook help
```

---

## 🔌 Model Context Protocol (MCP) Integration

Intellibook AI offers a public, streamable HTTP MCP server that AI agents (Claude Desktop, Cursor, ChatGPT) can interact with directly to search businesses and book appointments with automatic WhatsApp confirmations.

- **MCP Endpoint**: `https://www.intellibookai.com/mcp`
- **MCP Manifest**: `https://www.intellibookai.com/mcp.json`
- **Documentation**: [https://www.intellibookai.com/docs#mcp](https://www.intellibookai.com/docs#mcp)

### Add to Claude Desktop (`claude_desktop_config.json`):
```json
{
  "mcpServers": {
    "intellibook-ai": {
      "type": "http",
      "url": "https://www.intellibookai.com/mcp"
    }
  }
}
```

---

## 📚 Key Resources & Free Tools

- **Website**: [Intellibook AI](https://www.intellibookai.com)
- **API Documentation & OpenAPI Spec**: [https://www.intellibookai.com/docs](https://www.intellibookai.com/docs)
- **Salon & Clinic No-Show Calculator**: [https://www.intellibookai.com/no-show-calculator](https://www.intellibookai.com/no-show-calculator)
- **Google Business Profile SEO Audit**: [https://www.intellibookai.com/google-business-profile-seo](https://www.intellibookai.com/google-business-profile-seo)
- **Privacy Policy**: [https://www.intellibookai.com/privacy](https://www.intellibookai.com/privacy)
- **Terms of Service**: [https://www.intellibookai.com/terms](https://www.intellibookai.com/terms)

---

## 📄 License

MIT © [Intellibook AI](https://www.intellibookai.com)
