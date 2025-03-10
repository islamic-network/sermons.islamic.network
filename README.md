# Sermons App and API

This repo hosts the static sermons API served at https://sermons.islamic.network/api.

It serves static json files with URLs to sermons hosted on the Islamic Network CDN.

This project began with making the UAE Awqaf sermons available for programmatic use as the actual Awqaf website allows 
for no way to do this and it's sometimes unavailable.

The API is produced from the code in https://github.com/islamic-network/uae-awqaf-khutba-downloader.

This repository may become the destination for other such khutbas and sermons.

This is provided in the hope that it may be useful in spreading the beautiful word in these sermons, in line with what the Qur'an says:

"Seest thou not how Allah coineth a similitude: A goodly saying, as a goodly tree, its root set firm, its branches reaching into heaven."
  -- Surah Ibrahim, Ayah 24 (14:24)

If you would like to add your sermons to the CDN or API, please reach out via https://community.islamic.network or support@islamic.network.


## Development
```
docker run -it --rm -v "$PWD":/usr/src/app -p "4000:4000" starefossen/github-pages
```

## Building the API

The code for the API resides in the `src` directory.
