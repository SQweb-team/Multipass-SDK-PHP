#!/bin/bash

# SQWEB - PHP SDK - RELEASE NOTIFIER
# ------------------------------------------------------------------------------
# Let the Slack team know that the release was successful.

curl -X "POST" "https://hooks.slack.com/services/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" \
     -H "Content-Type: application/x-www-form-urlencoded; charset=utf-8" \
     --data-urlencode "payload={\"text\": \"$TRAVIS_TAG released on GitHub + Packagist.\"}"
