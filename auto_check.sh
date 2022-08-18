#!/bin/sh

# 监听目录
listen_dir=$1

# 运行脚本
script=$2

inotifywait -mrq --format '%e' --event create,delete,modify  $filename | while read event
  do
      case $event in MODIFY|CREATE|DELETE) bash $script ;;
      esac
  done
