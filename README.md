# Draft League of Legend

This client tool made with php and node, was created to let you quickly see what counter you should pick in a draft of league of legend. 

## Setup :

First start by clonning the repository :

```bash
git clone https://github.com/Nakatox/draft_lol.git

cd draft_lol
```

and in the “script” folder :

```bash
cd ..

cd script

composer dump-autoload
```

## Client :

Once all installed, stay in the script folder and try the “help” command :

 

```bash
./cli.php command
```

All available command :

```bash
./cli.php draft 

./cli.php simple-counter

./cli.php all-counter
```

### Foncionnality :

- The first one, “draft”, will ask you step by step to specify all enemies champions.

After that, **all the counter for each role** will be displayed on your terminal with items suggested by champions. 

- The “simple counter” command will ask you a specified champion and a lane.

After that,  **all posssible counter for one champion** will be displayed with items suggested.

- The “all counter” command is pretty much the same but you just need to enter a champion, not a lane.

After that, **all lane** will be displayed **with counters from each** lane, and items suggested too.

## Back-end :

### Scrapping :

We use **scrapping tool** to automaticly update the suggested items for each champions with the current meta.

The scrapping tool will run **every day at 00:00 AM**, powered with github action.

**To do it manually :**

Start by installing the dependencies :

```bash
cd scrapping

yarn 
```

Then you need to run the following command :

```bash
npm run start
```

And then wait for the information to be updated in “/scrapping/champion.json”

## Unit test :

To check if everything working properlly, you can always execute some test with the following command

```bash
(on the default folder)

php unitTest.php
```

If the fucntion return “True” for each case, then everything is working.