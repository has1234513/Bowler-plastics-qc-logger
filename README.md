# Factory QC Environmental Logger — Technical Assessment

## Overview

Welcome to the full-stack technical assessment. You have **2 hours** to build a working prototype of an **Ambient Conditions Logger** for a plastics manufacturing Quality Control (QC) team.

Please read the full assessment brief in **[ASSESSMENT.md](ASSESSMENT.md)** before you begin.

## Pre-configured Stack

This repository comes pre-configured with everything you need:

- **Laravel 13** with PHP 8.4
- **React 19** with TypeScript
- **Inertia.js v3** (React adapter)
- **Tailwind CSS v4**
- **Pest v4** for testing
- **SQLite** database (pre-configured)
- **Laravel Breeze** authentication scaffolding

## Getting Started

### Prerequisites

- PHP 8.4+
- Composer
- Node.js 20+
- npm

### Setup

1. **Clone this repository** and push it to a new **private repository** on your GitHub account:

   ```bash
   git clone https://github.com/Bowler-Plastics/assessment.git
   cd assessment

   # Remove the existing git history and start fresh
   rm -rf .git
   git init
   git add .
   git commit -m "Initial commit"

   # Link to your new private repository and push
   git remote add origin <your-new-private-repo-url>
   git branch -M main
   git push -u origin main
   ```

2. **Add the reviewer to your repository:**

   Add **[RupertBothma](https://github.com/RupertBothma)** as a collaborator to your new private repository. Please do this as one of your first steps!
   *Note: We would like to see commits pushed to the repo from the start to see how the project is progressing.*

3. **Run the setup script:**

   ```bash
   composer setup
   ```

   This will install PHP and Node dependencies, generate an app key, run migrations, and build frontend assets.

4. **Start the development servers:**

   In one terminal:
   ```bash
   php artisan serve
   ```

   In another terminal:
   ```bash
   npm run dev
   ```

5. **Open your browser** at [http://localhost:8000](http://localhost:8000)

### Running Tests

```bash
php artisan test --compact
```

To run a specific test file:
```bash
php artisan test --compact --filter=YourTestName
```

### Code Formatting

After modifying PHP files, run Pint to auto-format:
```bash
vendor/bin/pint --dirty
```

## What To Do Next

1. Read **[ASSESSMENT.md](ASSESSMENT.md)** for the full project brief and task breakdown.
2. Create a **THOUGHTS.md** file in the root directory to document your process (see the assessment brief for details).
3. Start coding — and commit frequently so we can see your workflow.

## AI Coding Tools

You are **encouraged** to use AI-assisted coding tools (GitHub Copilot, Cursor, Claude Code, ChatGPT, etc.) during this assessment. We want to see how you leverage these tools effectively as part of a modern development workflow.

Document your AI tool usage in your THOUGHTS.md file.

Good luck!
