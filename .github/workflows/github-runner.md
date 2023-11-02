## some documentation for runner
- https://habr.com/ru/articles/737148/
- https://github.com/orgs/community/discussions/46153

## step by step manual - for start runner
- В репозитории переходим в Settings → Actions → Runners → New self-hosted runner
- Указываем параметры нашего VPS. У меня это Linux. Архитектура процессора - x64. После этого появятся автосгенерированные скрипты для настройки раннера.
- Вводим первую группу скриптов:
```shell
# Create a folder
$ mkdir actions-runner && cd actions-runner
# Download the latest runner package
$ curl -o actions-runner-linux-x64-2.311.0.tar.gz -L https://github.com/actions/runner/releases/download/v2.311.0/actions-runner-linux-x64-2.311.0.tar.gz
# Optional: Validate the hash
$ echo "29fc8cf2dab4c195bb147384e7e2c94cfd4d4022c793b346a6175435265aa278  actions-runner-linux-x64-2.311.0.tar.gz" | shasum -a 256 -c
# Extract the installer
$ tar xzf ./actions-runner-linux-x64-2.311.0.tar.gz
```
- Запускаем скрипт конфигурации. Из всех дефолтных значений я изменил только название раннера:
```shell
# Create the runner and start the configuration experience
$ ./config.sh --url https://github.com/progr000/small-framework --token ADZB6WQHRZPOD6272NIEHT3FIPQP6
```
- Теперь можно запускать раннер. Для демонстрационных целей сделать это можно в фоновом режиме с помощью nohup:
```shell
# Last step, run it!
$ ./run.sh
# or
$ nohup ./run.sh > runner.logs &
```
- Проверим статус раннера в GitHub.
### Создание пайплайна.
- Все скрипты пайплайнов должны лежать в специальной папке {проект}/.github/workflows .
- создаем в проекте файл c таким путем:
```
project-dir/.github/workflows/deploy-job.yml
```
- и с примерно таким содержимым:
```yaml
name: Deploy
on:
  push:
    branches: [ "dev" ]
jobs:
  pullProject:
    runs-on: self-hosted
    steps:
    - name: Pull Project
      run: |
        cd /mnt/my-personal-data/work/www/test.localhost
        git pull origin dev
```
- Коммитим, пушим, ждем, смотрим на результат.
- https://github.com/progr000/small-framework/actions

## Для реальных проектов рекомендуется запускать раннер в качестве сервиса. Сделать это можно при помощи скрипта svc.sh, который автоматически загружается при настройке раннера.

```shell
progr@MWS-MN-023:~/test/actions-runner$ sudo ./svc.sh

Usage:
./svc.sh [install, start, stop, status, uninstall]
Commands:
   install [user]: Install runner service as Root or specified user.
   start: Manually start the runner service.
   stop: Manually stop the runner service.
   status: Display status of runner service.
   uninstall: Uninstall runner service.
```
- После установки и настройки раннера необходимо выполнить команду install.
- Затем для исполнения станут доступны остальные команды.
- 