# Syntagma

## What the project is

Syntagma is a syntax engine. The engine rests on the Generative Grammar of Noah Chomsky. The engine sorts every sentence into one of five construction schemes. The schemes run from S1 to S5.

Sixteen word classes carry the morphology. The learner meets the word classes in his own language first. The learner then meets the same structures under every Indo-European language he takes.

The learner builds simple, compound and complex sentences. The engine checks each sentence against the scheme table.

## How to run it

Run every command from the repository root. The entry file in showroom/ reads `SYNTAX_BASE` to reach autoload.php, so export the variable first.

```
export SYNTAX_BASE=/syntax/
php -S 127.0.0.1:8116 -t showroom showroom/index.php
```

The runner in tests/ executes the suite.

```
php tests/run.php
```

## What the routes answer

The router serves the page route at /. The front controller answers this route with the HTML page.

The router also serves the probe route at /status. The probe route answers JSON with the keys ok, schemes, sentences and sorted.

## How the layout is arranged

- The file autoload.php loads the classes.
- The directory src/Home/ holds the model. Word.php holds one word with its spelling and its word class. The method isCore() says whether the class is a core. Sentence.php holds the words of one sentence, lists the cores and says whether a word class appears in it. Engine.php holds the scheme table, counts the cores and sorts a sentence into S1 to S5. A preposition forces scheme S5 before the engine counts the cores. Sample.php builds the engine and its sentences.
- The directory src/App/ holds the router, the front controller and the HTML.
- The directory showroom/ holds the demo entry file and the stylesheet.
- The directory tests/ holds the runner, the assertion helper and the test file.
- The directory deploy/ holds the systemd unit and the nginx location block.

## The state of the suite

The suite runs 12 checks. The runner in tests/ executes each check. The contributor starts the suite with the command below.

```
php tests/run.php
```

## Licence

The repository uses the Mozilla Public License 2.0. The licence lets anyone use, change and share the code. The licence lets anyone combine these files with code under other terms. The licence requires each changed file to stay under the same licence. The licence also grants each recipient patent rights from the contributors.
