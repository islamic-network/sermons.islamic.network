## To regenerate the API files
Run:

```
s3cmd ls s3://cdn.islamic.network/sermons/uae-awqaf/doc/ > downloads/doc/doc.txt
s3cmd ls s3://cdn.islamic.network/sermons/uae-awqaf/pdf/ > downloads/pdf/pdf.txt
s3cmd ls s3://cdn.islamic.network/sermons/uae-awqaf/mp3/ > downloads/mp3/mp3.txt
mkdir api
php api.php
cp index.md api/
mv api ../
```
