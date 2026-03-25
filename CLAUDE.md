# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a greenfield Laravel project.

## Communication Style
- Use direct, factual responses without unnecessary agreement phrases
- Avoid confirmatory language like "You're correct," "Absolutely," "Brilliant," "Great idea," "Perfect," or similar validation terms
- Respond with objective analysis and implementation details rather than subjective praise
- Focus on technical accuracy and actionable information
- Provide only technical and useful replies — no conversational fluff or social pleasantries
- Skip introductory phrases, conclusions, and explanations unless specifically requested
- Answer with implementation details, code solutions, or specific technical guidance only

## Development Commands

### Dependencies
```bash
# Install dependencies
composer install --no-ansi --no-interaction --prefer-dist --optimize-autoloader

# Update frontend dependencies (after composer update)
cd ./app/Plugin/Websites/ && yarn install
```

### Database
```bash
# Run migrations
php artisan migrate
```

### Local Development Environment

#### MySQL Database Setup
The local development environment uses a MySQL Docker container:

```bash
# Connect to MySQL
E:\Software\wamp64\bin\mariadb\mariadb11.5.2\bin\mysql.exe -u root
```

**Connection Details:**
- Host: `localhost` (or `127.0.0.1`)
- Port: `3306`
- Username: `root`
- Password: ``

## Technology Stack

### Core Technologies
- **PHP 8.3** with strict typing
- **Laravel 6.4** for modern components

### Key Dependencies
- PHPUnit for testing
