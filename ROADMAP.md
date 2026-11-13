# Roadmap

The repository holds a working engine today. The model in src/Home carries the words, the sentences and the scheme table. The router and the front controller in src/App serve the page route and the probe route. The demo entry file in showroom presents the engine on a web page. The suite in tests runs 12 checks. The deploy directory holds the systemd unit and the nginx location block.

A contributor could add any of these capabilities next.

1. A contributor could add a form to the page. The learner would type a sentence. The engine would sort it. The page would show the scheme. The work would touch the HTML and the router in src/App/.

2. A contributor could add a parser for raw text. The parser would split a sentence into words. The parser would tag each word with its class. The work would touch src/Home/Word.php and src/Home/Sentence.php.

3. A contributor could add a store for checked sentences. The store would keep each sentence and its scheme for later study. The work would touch src/Home/Sentence.php and a new class in src/Home/.

4. A contributor could add a route that answers the full scheme table as JSON. The work would touch the router and the front controller in src/App/.

5. A contributor could add checks for the preposition rule and for the core count. The work would touch the test file and the runner in tests/.
