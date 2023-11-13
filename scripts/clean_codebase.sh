# Delete Drupal test directories.
# https://unix.stackexchange.com/a/89937
find . -type d -name tests -exec rm -rf {} +
# Delete testing and demo profiles.
find web/core/profiles -type d -name 'testing*' -exec rm -rf {} +
find web/core/profiles -type d -name 'nightwatch_testing' -exec rm -rf {} +
find web/core/profiles -type d -name 'demo_umami' -exec rm -rf {} +
# Delete README files.
find . -type f -name 'README*' -delete
find . -type f -name 'CHANGELOG*' -delete
# Delete patch records.
find . -type f -name 'PATCHES.txt' -delete
# Delete markdown files except licenses.
find web -type f -name "*.md" -not -name "LICENSE*" -delete
# Delete txt files except licenses.
find web -type f -name "*.txt" -not -name "salt*" -not -name "humans*" -not -name "LICENSE*" -not -name "COPYRIGHT*" -delete
