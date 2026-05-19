# Assessment Brief: Factory QC Environmental Logger

**Time Limit:** 2 hours
**Difficulty:** Full-Stack Developer

---

## The Scenario

You work for a plastics manufacturing company based in South Africa. Your polymer resins and injection moulding processes are sensitive to ambient temperature and humidity. When a client reports a product defect weeks after production, the Quality Control (QC) team needs to look back at the exact environmental conditions at the factory during that batch's production run.

Currently, nobody tracks this data. You are building the first prototype.

## The Challenge

Build an **"Ambient Conditions Logger"** — a web application where a QC Inspector can:

1. Enter a **Batch Number** (e.g., `BATCH-9942`)
2. Click **"Log Current Conditions"**
3. The backend fetches the current temperature and humidity for the factory's location from a public weather API
4. The data is saved to the database, linked to that Batch Number
5. A dashboard displays a log table of all recorded entries

## The API

You will use the free **[Open-Meteo API](https://open-meteo.com/)** — no API keys or authentication required.

**Endpoint (Johannesburg factory):**

```
GET https://api.open-meteo.com/v1/forecast?latitude=-26.2041&longitude=28.0473&current=temperature_2m,relative_humidity_2m&timezone=Africa/Johannesburg
```

**Example response:**

```json
{
  "current": {
    "time": "2024-03-15T14:00",
    "interval": 900,
    "temperature_2m": 24.3,
    "relative_humidity_2m": 62
  },
  "current_units": {
    "temperature_2m": "\u00b0C",
    "relative_humidity_2m": "%"
  }
}
```

You can test this in your browser right now to see the live response.

---

## Tasks

### Task 1: Backend & API Integration (approx. 45 minutes)

**Database:**
- Create an `EnvironmentalLog` model and migration
- Required fields:
  - `batch_number` — string, must be unique
  - `temperature_celsius` — decimal/float
  - `humidity_percent` — integer
  - `logged_at` — datetime (when the reading was taken)

**Service/Action Class:**
- Create a service or action class to encapsulate the Open-Meteo API call
- Use Laravel's `Http` facade to fetch the current weather data
- Parse the JSON response to extract `temperature_2m` and `relative_humidity_2m`

**Controller & Validation:**
- Create a controller with `index` and `store` methods
- Create a Form Request to validate the incoming `batch_number`:
  - Required
  - String
  - Unique in the `environmental_logs` table
- In the `store` method: validate input, call the weather service, combine the data, and save to the database

**Routing:**
- `GET /qc` — Display the dashboard with existing logs
- `POST /qc` — Submit a new batch number and log conditions

---

### Task 2: Frontend Development (approx. 40 minutes)

**Dashboard Page:**
- Create a React page component (e.g., `Pages/QC/Index.tsx`)
- Use **Tailwind CSS** to build a clean, readable layout suitable for a factory floor environment (think: large text, clear contrast, easy to scan)

**Submission Form:**
- Use Inertia's `useForm` hook to manage the form state
- Single text input for the Batch Number and a submit button ("Log Current Conditions")
- Show inline validation errors (e.g., duplicate batch number)
- Display a loading/processing state while the API call is in flight (disable the button, show feedback like "Fetching conditions...")

**Log Table:**
- Below the form, display a table of all previously logged entries
- Show: Batch Number, Temperature, Humidity, and the date/time logged
- Format data for readability (e.g., "24.3 \u00b0C", "62%", formatted date)

---

### Task 3: Testing (approx. 20 minutes)

Write an HTTP Feature Test (e.g., `EnvironmentalLogTest`).

**Required test cases:**

1. **Success case:** Use `Http::fake()` to mock the Open-Meteo API response. Submit a valid batch number. Assert that:
   - The response is successful (redirect or Inertia response)
   - The database contains a new `environmental_logs` record with the mocked temperature and humidity values

2. **Validation case:** Submit a duplicate batch number. Assert that:
   - A validation error is returned
   - No new record is created in the database

**Important:** Your tests must **never** call the live Open-Meteo API. Use `Http::fake()` to mock external requests.

---

### Task 4: Documentation (continuous, approx. 15 minutes)

Create a **`THOUGHTS.md`** file in the project root. Throughout the assessment, document:

1. **AI Tool Usage:** Be transparent about how you used Copilot, Cursor, ChatGPT, Claude, or any other AI coding tools. Examples:
   - "Used Copilot to generate the migration boilerplate"
   - "Prompted Claude to help structure the `Http::fake()` mock payload"
   - "Used ChatGPT to scaffold the Tailwind table layout"

2. **Architecture Decisions:** Explain *why* you structured the code the way you did. Examples:
   - "Put the API call in a dedicated service class because..."
   - "Used a Form Request instead of inline validation because..."
   - "Calculated the logged_at timestamp server-side because..."

3. **Compromises & Trade-offs:** What would you do differently with more time? Examples:
   - "Skipped error handling for API timeouts to focus on the happy path"
   - "Would add pagination to the log table for production use"
   - "Would extract the API coordinates to a config file"

---

## What We Are Evaluating

| Area | What We Look For |
|---|---|
| **Laravel Backend** | Clean separation of concerns, proper use of Form Requests, service/action classes, correct use of the `Http` facade, Carbon for dates |
| **React/Inertia Frontend** | Proper use of `useForm`, handling of `processing` state, clean component structure, inline error display |
| **Tailwind CSS** | Readable, responsive layout — does it look like something a factory worker could actually use? |
| **API Integration** | Resilient HTTP calls, proper JSON parsing, awareness of what could go wrong |
| **Testing** | Correct use of `Http::fake()`, meaningful assertions, isolation of external dependencies |
| **Workflow & Communication** | Quality of THOUGHTS.md, commit history, pragmatic use of AI tools |

---

## Tips

- **Commit frequently.** We want to see your workflow, not just the final result.
- **Don't over-engineer.** A working prototype with clean code beats a half-finished architecture masterpiece.
- **Use AI tools.** This is not a memory test. We want to see you work the way you actually work.
- **If you get stuck on CSS, move on.** Backend logic and testing are higher priority than pixel-perfect styling.
- **Read the API response.** Hit the Open-Meteo URL in your browser first so you understand the JSON structure before writing code.

---

## Time Budget Summary

| Task | Time |
|---|---|
| Backend & API Integration | ~45 min |
| Frontend (React/Inertia/Tailwind) | ~40 min |
| Testing | ~20 min |
| Documentation (THOUGHTS.md) | ~15 min (continuous) |
| **Total** | **2 hours** |

Good luck!
