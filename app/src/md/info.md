# PipelineDB Information

## High-performance time-series aggregation for PostgreSQL

PipelineDB is an open-source PostgreSQL extension that runs SQL queries continuously on streams, incrementally storing results in tables.

PipelineDB is running locally on port 5430. You can connect via any normal Postgres means, including the terminal if you have psql installed.

## Connect

Download a Postgres client, such as the following:

 * [Postico](https://eggerapps.at/postico/) (MacOS)
 * [DBeaver](https://dbeaver.io/download/) (Windows, MacOS, Linux)

Add the following connection details:

|Name| Value|
|----|------|
|`host` | localhost |
|`port` | 5430  |
|`user` | postgres |
|`password` | postgres  |

## Create a Stream

Streams are the entry points for data. Think of them as a table, but one which doesn't retain any data. You insert into streams, but the data is not added as a row.

A stream with 2 integers as the input

    CREATE FOREIGN TABLE
      demo_stream1 (x integer, y integer)
    SERVER pipelinedb;

A stream with 2 varchar and 1 boolean input:

    CREATE FOREIGN TABLE
      demo_stream2 (first_name varchar, last_name varchar, happy boolean)
    SERVER pipelinedb;

## Create a Continuous View

Continuous Views are what aggregate the data. Think of them like a view (or SQL statement), that gets updated every time a "record" is added to the stream.

A continuous view that adds the sum of the 2 integers in stream1 and keeps a running aggregation:

    CREATE VIEW demo_view1 AS
      SELECT sum(x + y)
      FROM demo_stream1;

A continuous view that takes the multiplication of the 2 integers in stream1 and keeps the highest total:

    CREATE VIEW demo_view2 AS
      SELECT MAX(x * y)
      FROM demo_stream1;

A continuous view that shows the number of records added to stream2 grouped by name:

    CREATE VIEW demo_view3 AS
      SELECT
        CONCAT(first_name,' ',last_name) AS "name",
        COUNT(first_name) AS "count"
      FROM
        demo_stream2
      GROUP BY
        CONCAT(first_name,' ',last_name);

A continuous view that shows the number of records added to stream2 where `happy` is true grouped by name:        

    CREATE VIEW demo_view4 AS
      SELECT
        CONCAT(first_name,' ',last_name) AS "name",
        COUNT(first_name) AS "count"
      FROM
        demo_stream2
      WHERE
        happy=TRUE
      GROUP BY
        CONCAT(first_name,' ',last_name);

If you make any mistakes, you can remove a continuous view:

    DROP VIEW demo_view9;

## Add some data

Demo Stream 1 (2 integers):

    INSERT INTO demo_stream1 (x, y) VALUES (5,7);
    INSERT INTO demo_stream1 (x, y) VALUES (9,9);
    INSERT INTO demo_stream1 (x, y) VALUES (3,0);

Demo Stream 2 (names and happy boolean):

    INSERT INTO demo_stream2 (first_name, last_name, happy)
    VALUES ('daniel','bougourd',true);

    INSERT INTO demo_stream2 (first_name, last_name, happy)
    VALUES ('daniel','bougourd',false);

    INSERT INTO demo_stream2 (first_name, last_name, happy)
    VALUES ('daniel','bougourd',true);

    INSERT INTO demo_stream2 (first_name, last_name, happy)
    VALUES ('donal','duck',true);

    INSERT INTO demo_stream2 (first_name, last_name, happy)
    VALUES ('daffy','duck',false);

## Look at the results

__Demo View 1__ (Sum of all the integers):

    SELECT * FROM demo_view1;

You should get a result of 33 (5+7+9+9+3+0)

__Demo View 2__ (Maximum of the 2 integers multiplied):

    SELECT * FROM demo_view2;

You should get a result of 81 (9*9)

__Demo View 3__ (Count of entries by name):

    SELECT * FROM demo_view3;

You should see a table with 3 entries, 4 counts for daniel, 1 for daffy and 1 for donald.

__Demo View 4__ (Count of entries by name where happy is true):

    SELECT * FROM demo_view4;

You should see a table with 2 entries, 3 counts for daniel and 1 for donald.

## Using COPY

`COPY` can be very useful for retroactively populating a continuous view from archival data. Here is an example using Wikipedia page traffic logs (a sample file is included in the `demo_data` folder of this repository).

Wikipedia logs have the following format:


      fr.b Special:Recherche/Achille_Baraguey_d%5C%27Hilliers 1 624
      fr.b Special:Recherche/Acteurs_et_actrices_N 1 739
      fr.b Special:Recherche/Agrippa_d/%27Aubign%C3%A9 1 743
      fr.b Special:Recherche/All_Mixed_Up 1 730
      fr.b Special:Recherche/Andr%C3%A9_Gazut.html 1 737

In the above, the first column `fr.b` is the project name. The following abbreviations are used:

|Name|Abbreviation|
|----|------------|
| wikibooks | .b |
| wiktionary | .d |
| wikimedia | .m |
| wikipedia mobile | .mw |
| wikinews | .n |
| wikiquote | .q |
| wikisource | .s |
| wikiversity | .v |
| mediawiki | .w |

Projects without a period and a following character are wikipedia projects.
The second column is the title of the page retrieved, the third column is the number of requests, and the fourth column is the size of the content returned.

Let's make a stream for this data:

    CREATE FOREIGN TABLE wiki_stream (
          project text,
          title text,
          view_count bigint,
          size bigint)
    SERVER pipelinedb;

And now a continuous view for aggregation:

    CREATE VIEW wiki_stats AS
    SELECT
      project,
      sum(view_count) AS total_views,
      sum(size) AS total_bytes_served
    FROM
      wiki_stream
    GROUP BY
      project;

Now we can use `COPY` on the file located in this repository's `pipelinedb/demo_data` folder, which is mounted in the container as `/tmp/demo_data`

  COPY wiki_stream (project, title, view_count, size) FROM '/tmp/demo_data/wikipedia_sample.txt' WITH DELIMITER ' '

We can then see the top 10 pages (by view count) from our sample data with the following query:

    SELECT *
    FROM
      wiki_stats
    ORDER BY
      total_views DESC
    LIMIT 10;

## COPY local data

To use the `COPY` command with local data we need to use `psql` from the terminal. You can test this by running:

    psql --version

If you see something like this, then you have psql installed:

    psql (PostgreSQL) 11.0 (Debian 11.0-1.pgdg90+2)

Now we can use `COPY` to send a local file to our PipelineDB server:

    cat wikipedia_sample.txt | psql -U postgres -h localhost -p 5430 -c "COPY wiki_stream (project, title, view_count, size) FROM STDIN WITH DELIMITER ' ';"

## Drop streams

To tidy up, you can drop the streams (and all the continuous views that use them) using:

    DROP FOREIGN TABLE demo_stream1 CASCADE;
    DROP FOREIGN TABLE demo_stream2 CASCADE;
