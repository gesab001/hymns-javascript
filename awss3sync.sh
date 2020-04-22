#!/bin/bash
aws s3 sync . s3://hymns.onecloudapps.net/ --exclude "awss3sync.sh" --exclude "hymns.json"
aws cloudfront create-invalidation --distribution-id E3T6ZLH069IO2 --paths "/*"
#arn:aws:iam::928050022863:role/lambda_invoke_function_assume_apigw_role
