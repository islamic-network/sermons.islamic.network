## To regenerate the API files
Run:

```
s3cmd -c ~/.s3cfg_hfsn ls s3://cdn-islamic-network/sermons/uae-awqaf/doc/ > downloads/doc/doc.txt
s3cmd -c ~/.s3cfg_hfsn ls s3://cdn-islamic-network/sermons/uae-awqaf/pdf/ > downloads/pdf/pdf.txt
s3cmd -c ~/.s3cfg_hfsn ls s3://cdn-islamic-network/sermons/uae-awqaf/mp3/ > downloads/mp3/mp3.txt
mkdir api
mkdir yaml
php api.php
cp index.md api/
rm -r ../api
mv api ../
cp -rf yaml/* ../_data/
rm -r yaml
```
