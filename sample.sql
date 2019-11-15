CREATE FOREIGN TABLE stream (x integer, y integer) SERVER pipelinedb;
CREATE VIEW v AS SELECT sum(x + y) FROM stream;
INSERT INTO stream (x, y) VALUES (5,7);
