# Thoughts & Process Log

> Document your thinking throughout the assessment. This is as important as the code itself.
> We want to understand *how* you work, not just *what* you built.

## AI Tool Usage

 - _"I used Claude Opus 4.7 on the Pro plan"_
 - _"I created a Project on claude and linked my repo to it as context"_
 - _"I had and issue running the `composer setup` and resolved it by re-installing composer and sqlite"_
 - _"To start creating the Backend api, withe the help of claude Opus 4.7, I scaffolded the Laravel backend for a QC environmental logging feature across create_environmental_logs_table.php (migration), EnvironmentalLog.php (model), StoreEnvironmentalLogRequest.php (validation), EnvironmentalLogController.php (controller), OpenMeteoService.php (weather API client), plus config additions in services.php and routes in web.php"_
 - _"For the Frontend, I use claude Opus 4.7 as well, I add the route qc route and placed teh input and logger table in one file"_
 - _"For the testing I updated the `tests/Feature/EnvironmentalLogTest.php` file using Clause Opus 4.7, I did run into a timezone issue which i had to fix in the `app/Services/OpenMeteoService.php` file


## Architecture Decisions

_Explain the "why" behind your code structure. For example:_

- _I placed the API integration logic In a dedicated OpenMeteoWeatherService class under app/Services/, so the controller stays thin, the Http facade call is isolated for Http::fake() mocking in tests, and the API contract has one place to evolve._
- _User input (batch_number) is validated by a Form Request and never trusted beyond that; the temperature, humidity, and logged_at timestamp are all generated server-side after validation, so the audit log can't be spoofed from the browser_
- _I used the patterns and conventions from the inital codebase_


## Compromises & Trade-offs

_What would you improve with more time? For example:_

- _"Did not add UI navigation from qc to dashboard page"_
- _"Would add pagination for the log table in production"_
- _"Placed the frontend in one file, instaed of using modular components"_
- _"Did not test and verify existing auth"_



## If I Had 2 More Days...

_What are the first 3 things you would change to make this production-ready?_

1. I would add end-to-end testing to ensure api and UI are working correctly or for cases such as if the user updates the browser etc..
2. I would ensure Proper authentication
3. I would add proper navigation on the UI
4. I would use Modular components on the frontend for code maintainability
