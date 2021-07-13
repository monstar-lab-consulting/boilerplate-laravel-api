## Overview
CircleCI for auto deploying to AWS

## Table of Contents
- [Environments](#environments)
- [Getting started](#getting-started)
    - [Prepare](#prepare)
    - [Steps](#steps)
        - [ECS](#ecs)

## Environments

| Branch                | Environment |
| --------------------- | ----------- |
| staging, staging-base | Staging     |
| prod, prod-base       | Production  |

## Getting started
### Prepare
- AWS deployment account: (AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY)
- Environment variables (normally located at .env) should be stored at [AWS System Managers](https://ap-northeast-1.console.aws.amazon.com/systems-manager/parameters/?region=ap-northeast-1&tab=Table).
- CircleCI environments:

| env                      | Environment | example                      |
| ------------------------ | ----------- | ---------------------------- |
| AWS_ACCESS_KEY_ID        |             | AKIASxxxxJAHP                |
| AWS_SECRET_ACCESS_KEY    |             | SECRETxxxxtks6               |
| AWS_ECR_ACCOUNT_URL      |             | {account_id}.dkr.ecr.ap-northeast-1.amazonaws.com          |
| AWS_ECR                  |             | repo-name                    |
| AWS_REGION               |             | ap-northeast-1               |
| AWS_SERVICE              |             | service-name                 |
| AWS_TASK_NAME            |             | task-name                    |

### Steps
- Create project and config CircleCI
- Get and set AWS environment into CircleCI Project Settings
- Push your source to staging-base branch to push base image
- Push your source to staging branch to update service
#### ECS
    - Get [ECS_TASK_FAMILY](https://ap-northeast-1.console.aws.amazon.com/ecs/home?region=ap-northeast-1#/taskDefinitions). Example: dev-boilerplate-task-blue-ecs-be
    - Update `ECS_TASK_FAMILY` in `deploy.sh` to value you have got above: dev-boilerplate-task-blue-ecs-be
