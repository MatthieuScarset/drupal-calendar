# Drupal Calendar

![image](https://github.com/MatthieuScarset/drupal-calendar/assets/7369593/8b75b16b-f29b-44d2-9b64-b022972dd0a1)

Get a working copy of [Drucal.org](https://drucal.org) website locally in minutes.

## Requirement

Follow instructions from [the project template](https://github.com/MatthieuScarset/drupal-template#usage).

## Usage

```bash
# Import new events from drupal.org
lando drush migrate:import event

# Import new and update all events.
lando drush migrate:import event --update
```

### Credits

- [Matthieu Scarset](https://matthieuscarset.com/)
- [Calendar View](https://drupal.org/project/calendar_view) contrib module.
- [Drupal Rest/JSON API](https://www.drupal.org/drupalorg/docs/apis/rest-and-other-apis) documentation.
