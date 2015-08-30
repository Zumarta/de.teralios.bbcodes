#Teralios' BBCodes
This is a package for the WoltLab® Community Framework 2.1 and adds some special bbcodes for text formatting.

The BBCodes add functions for headings, definition lists, footnotes, pro- & contralists, content boxes and attachments.

##BBCodes
###Heading and subheading BBCode
Adds heading and subheading to a bbcode text.
```
[heading]Headline[/heading]
[h1]Headline[/h1]
[subheading]Subheadline[/subheading]
[h2]Subheadline[/h2]
```

This bbcodes have one attribute to add a anchor and a share option to the heading.
```
[h1=anchor]Headline[/h1]
```
###Footnotes
The footnote function adds 2 bbcodes. Footnote and footnote content (shortform: fn and fnc). With this two bbcodes you can add footnotes to a text.

Simple
```
Some text[fn]Text of a footnote[/fn].
```
The content of fn will put to the end of the site.


You can seperating the footnote mark and the content of the footnote. It's look like this:
```
Some text[fn=footnote1][/fn].
some other text.
[fnc=footnote1]Text[/fnc]
```
###Definition list
For use a definition list in a bbcode text, use this syntax
```
[dlist]
[*]Key[:]Value
[*]Key2[:]Value2
[/dlist]
```

##Licence
This package is free software and published under the Creative Commons Attribution-ShareAlike 4.0 International Public License
