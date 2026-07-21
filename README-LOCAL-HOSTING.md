# Local Hosting with XAMPP and ngrok

Use this project locally without paid hosting by running Laravel on your machine and exposing it with ngrok.

## Recommended setup

1. Place the project inside your XAMPP document root if you prefer Apache:
   - `C:\xampp\htdocs\simrs-rsud-malang`
2. Or use the built-in PHP development server from this repository root.
3. Make sure MariaDB is running in XAMPP or your local environment.

## Quick start using PowerShell

From the project root:

```powershell
.\run-local-ngrok.ps1
```

This will:
- start Laravel local server on `http://127.0.0.1:8000`
- start `ngrok` and expose the same port publicly

## Quick start using batch file

From the project root double-click or run:

```bat
run-local-ngrok.bat
```

## If ngrok is not installed

1. Download ngrok from https://ngrok.com/download
2. Install it and add it to your PATH
3. Run `ngrok http 8000`

## Access URLs

- Local: `http://127.0.0.1:8000`
- Public: copy the `Forwarding` URL from the ngrok window

## Notes

- The app is only available while your PC and ngrok are running.
- If you want a stable URL, sign up for a free ngrok account and configure an auth token.
- This avoids paid hosting while still allowing anyone with the URL to access it.
