#!/bin/bash

usage() {
  echo "USAGE: view.sh [file]..." 1>&2
  exit 1
}

view() {
  file=$1
  if [ -f $file -a -r $file ]; then
    gunzip -c $file > /tmp/view-tmp-$file 2> /dev/null
    if [ $? == 0 ]; then
      cat /tmp/view-tmp-$file
    else
      cat $file
    fi
    rm /tmp/view-tmp-$file
  else
    echo "ERROR: Cannot read file $file"
  fi
}

if (( $# < 1 )); then
  usage
fi

for arg in $@; do
  view $arg
done
