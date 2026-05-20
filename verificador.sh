  #!/bin/bash
  
url="http://apuestas11.us.to/"
#url="http://localhost/"
  tempfile=$(mktemp)

  code=$(curl -s $url --write-out '%{http_code}' -o $tempfile)

    
echo "$url SAID $code"
  if [[ $code != 200  ]] ; then
echo "$url SAID $code"
/sbin/service httpd restart
   #  rm -f $tempfile
  #  return $code
  fi

  #mv $tempfile $target