#!/bin/bash
echo "nama project: [ENTER]:"
read name
gcloud app deploy ../public/app.yaml --project $name
gcloud app browse
