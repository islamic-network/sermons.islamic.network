---
layout: default
title: Sermons API by Islamic Network
header: Sermons API
meta:
description: An API to programmatically access Khutbas and Sermonds from Islamic Network
---

<div class="px-4 py-2 sm:px-0">
    The sermons project is all about making khutbas from the Islamic World programmatically accessible to developers and the wider community.
</div>
<div class="px-4 sm:px-0">
    This is done by making the mp3, pdf and document files available for khutbas on the Islamic Network CDN and providing a static JSON API
which is essentially a traversable map of the khutba files on the CDN.
</div>
<div class="px-4 py-2 sm:px-0">
<h2 class="text-3xl font-bold leading-tight">API</h2>
</div>
<div class="px-4 sm:px-0">
    The API is split up into sources, languages and years. Currently, the only source is UAE Awqaf.
</div>
<div class="px-4 py-2 sm:px-0">
    <h2 class="text-1xl font-bold leading-tight">Sources</h2>
</div>
<div class="px-4 sm:px-0">
    To see all sources: <a href="/api/sources.json" target="_blank" class="text-green-700">https://sermons.islamic.network/api/sources.json</a>.
<br />
    Each source can be traversed using its handle and the year you would like to access khutbas for.
</div>
<div class="px-4 py-2 sm:px-0">
    <h2 class="text-1xl font-bold leading-tight">Khutbas for a year</h2>
</div>
<div class="px-4 sm:px-0">
    To get all UAE Awqaf khutbas for 2021: <a href="/api/uae-awqaf/2021.json" target="_blank" class="text-green-700">https://sermons.islamic.network/api/uae-awqaf/2021.json</a>.
    <br />
    To get all Friday UAE Awqaf khutbas for 2021: <a href="/api/uae-awqaf/2021/friday.json" target="_blank" class="text-green-700">https://sermons.islamic.network/api/uae-awqaf/2021/friday.json</a>.
    <br />
    To get all non-Friday (Eid, for example) UAE Awqaf khutbas for 2021: <a href="/api/uae-awqaf/2021/other.json" target="_blank" class="text-green-700">https://sermons.islamic.network/api/uae-awqaf/2021/other.json</a>. 
    <br />
    To get all Friday (Eid, for example) UAE Awqaf khutbas for the month of July in 2021: <a href="/api/uae-awqaf/2021/07/friday.json" target="_blank" class="text-green-700">https://sermons.islamic.network/api/uae-awqaf/2021/07/friday.json</a>.
    <br />
    To get all non-Friday (Eid, for example) UAE Awqaf khutbas for July 2021 (please note that not all months will have a non Friday khutba, as these only exist for months where Eid holidays fall or there was a rain sermon): <a href="/api/uae-awqaf/2021/07/other.json" target="_blank" class="text-green-700">https://sermons.islamic.network/api/uae-awqaf/2021/07/other.json</a>.
</div>
<div class="px-4 py-2 sm:px-0">
<h2 class="text-1xl font-bold leading-tight">Languages</h2>
</div>
<div class="px-4 sm:px-0">
To see all languages: <a href="/api/languages.json" target="_blank" class="text-green-700">https://sermons.islamic.network/api/languages.json</a>.
<br />
This endpoint is provided to easily expand on the language codes within the khutba JSON to build UIs.
</div>

<div class="px-4 py-2 sm:px-0">
<h2 class="text-2xl font-bold leading-tight">Copyright</h2>
</div>
<div class="px-4 sm:px-0">
The copyright for all khutbas and contents remains with the source. Islamic Network is only making these programmatically accessible.
</div>

<div class="px-4 py-2 sm:px-0">
<h2 class="text-2xl font-bold leading-tight">Want to add your khutbas?</h2>
</div>
<div class="px-4 sm:px-0">
Please get in touch via <a href="https://community.islamic.network" target="_blank" class="text-green-600">https://community.islamic.network</a>.
</div>
<!-- /End replace -->
