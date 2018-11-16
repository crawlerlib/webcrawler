#  IP518bb QuizGenerator - Website crawler

This application crawls a given websize and outputs all its texts.

## Getting started

 1. Clone this repository:
     `git clone ...`
     
 2. Install dependencies:
     `composer install`

## Crawling a website

To crawl any given website, execute the following command, for instance for `http://www.laeufelfingen.com`:

```
./crawler.php crawl www.laeufelfingen.com
```

To store all texts in a file, pipe the commands output to a file:

```
./crawler.php crawl www.laeufelfingen.com > some-text-file.txt
```

To crawl most of the www.laeufelfingen.com website, execute the following:

```
./crawler.php crawl www.laeufelfingen.com/ www.laeufelfingen.com/div/lf.htm www.laeufelfingen.com/div/Lage.htm www.laeufelfingen.com/div/Lflied.htm www.laeufelfingen.com/div/name.htm www.laeufelfingen.com/bahn/c/chronik.htm www.laeufelfingen.com/grenzsteine/42.03%20Homberg/42.03%20Homberg.htm www.laeufelfingen.com/chrsta/ChronikSchaubEin.htm www.laeufelfingen.com/chrsta/landw.htm www.laeufelfingen.com/chrsta/Chronik_E_Schaub_schule.htm > output/laeufelfingen.csv
```
