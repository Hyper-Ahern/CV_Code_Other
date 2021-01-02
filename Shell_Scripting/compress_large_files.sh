#!/bin/bash

usage() {
  echo "USAGE: compress_large_files.sh size [dir]..." 1>&2
  exit 1
}

compressfile() {
  if [ -r $1 -a -w $1 ]; then
    fsize=`stat -f '%z' $1`
    if (( $fsize >= size )); then
      gzip $1 2> /dev/null
      if [ $? != 0 ]; then
        echo "ERROR: Failed to compress file $1" 1>&2
      fi
    fi
  else
    echo "ERROR: Cannot read or write file $1" 1>&2
  fi
}

compressdir() {
  if [ ! -d $1 ]; then
    echo "ERROR: $1 is not a directory"
  elif [ ! -r $1 -o ! -w $1 -o ! -x $1 ]; then
    echo "ERROR: Cannot read or write directory $1"
  else
    cd $1
    for f in *; do
      if [ -f $f ]; then
        compressfile $f
      fi
    done
  fi
}

if (( $# < 1 )); then
  usage
fi

echo $1 | egrep '^[0-9]+$' > /dev/null
if [ $? != 0 ]; then
  echo "ERROR: $1 is not a number" 1>&2
  exit 1
fi

size=$1
shift

if (( $# == 0 )); then
  compressdir .
else
  for arg in $@; do
    (compressdir $arg)
  done
fi
