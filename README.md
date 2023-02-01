# partochr

## What is partochr?

Partochr is a music sheet manager, intended for use in a private circle (therefore avoiding copyright issues).
Feel free to copy and deploy it on your own server... and to improve it by suggesting new ideas, filing bug reports or improve the codebase.

MVP Features : 
- CRUD songs (lyrics and chords - integrated WYSIWYG editor)
- List all songs from a same artist
- CRUD workbooks and add/remove songs to workbooks
- Follow/unfollow workbooks
- Search through all songs, workbooks and artists

It is not possible to use the app (access songs...) without login first.

## Stack

Laravel8, Vue3, Intertia, Laravel Scout, Quill (WYSIWYG plugin)

## First launch

- update your .env with your dev environment variables
- run `composer install`
- run `php artisan migrate`
- run `npm install`
- run `yarn build`
- run `php artisan serve`

