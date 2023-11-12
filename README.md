# Drupal Calendar

![image](https://github.com/MatthieuScarset/drupal-calendar/assets/7369593/8b75b16b-f29b-44d2-9b64-b022972dd0a1)

Get a working copy of [Drucal.org](https://drucal.org) website locally in minutes.

## Requirement

Install [Lando](https://docs.lando.dev/drupal/) on your machine.

## Usage

Click on the button _Use this template_ to generate your own project, then:

```bash
git clone git@github.com:<UsernameOrOrganization>/drupal-template.git drucal

cd drucal

# Replace the project name (i.e. 'drucal').
code .env.example    # ->  DRUSH_OPTIONS_URI=https://drucal.lndo.site
code .lando.yml      # ->  name: drucal

# Create your env file now
cp .env.example .env

# Commit your changes
git add . && git commit -m "Rename project" && git push

# Start the project
lando start

# Download dependencies
lando composer install -o

# Install Drupal
lando drush site:install --existing-config -y
lando drush user:password admin admin
lando drush user:login # -> Ctrl+Click the URL to open your site :)
```

Start to build things!
