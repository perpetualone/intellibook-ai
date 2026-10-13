# Intellibook AI: developer tools

Open-source tools for [Intellibook AI](https://www.intellibookai.com), a 24/7 AI receptionist that answers customers on WhatsApp and Instagram, qualifies leads and books appointments for clinics, salons, spas, gyms and other service businesses in India.

This repository holds the public developer tooling. The Intellibook AI platform itself is a hosted service.

| Folder | What it is |
|---|---|
| [`packages/cli`](packages/cli) | `intellibook-ai` command-line tool: search businesses, check slots, run a Google Business Profile audit. |
| [`plugins/wordpress`](plugins/wordpress/intellibook-ai-receptionist) | WordPress plugin: floating "Book on WhatsApp" button and a booking-page shortcode. |
| [`packages/homebrew`](packages/homebrew) | Homebrew formula and publishing notes for the CLI. |

## MCP server

Intellibook AI runs a public [Model Context Protocol](https://modelcontextprotocol.io) server (Streamable HTTP, no authentication):

- Endpoint: `https://www.intellibookai.com/mcp`
- Manifest: `https://www.intellibookai.com/mcp.json`
- Tools: `searchBusinesses`, `getBusinessServices`, `getAvailableSlots`, `createBooking`
- Docs: <https://www.intellibookai.com/docs#mcp>

Claude Desktop / Cursor configuration:

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

Bookings made through an assistant are confirmed to the customer on WhatsApp. No payment is taken through the MCP server.

## REST API

Documentation and OpenAPI spec: <https://www.intellibookai.com/docs> and <https://www.intellibookai.com/api/openapi.json>.

## License

MIT. See [LICENSE](LICENSE). The WordPress plugin is GPLv2 or later, as WordPress.org requires.

## Support

support@intellibookai.com
