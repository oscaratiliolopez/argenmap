BEGIN;
CREATE TABLE "graph2" (gid serial, "source_id" varchar, "target_id" varchar, "type" varchar, "type_rev" varchar);
SELECT AddGeometryColumn('','graph2','the_geom','-1','MULTILINESTRING',2);
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('0','R','V',NULL,NULL,'010500000001000000010200000002000000FE7D2E0BDFE7D6BF43F891048CA34940C15DD4EA3E59D7BFE69B48764DBA4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('1','Q','P','highway','highway','010500000001000000010200000002000000D05A835C129CDABF48282A92BFD14940A04F6EF05A9BDEBF754CD6180BCA4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('2','W','P',NULL,NULL,'010500000001000000010200000002000000A04F6EF05A9BDEBF754CD6180BCA4940EDFBFE63467CD8BF819EDF7B21CA4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('3','E','R',NULL,NULL,'010500000001000000010200000002000000C15DD4EA3E59D7BFE69B48764DBA494031C48341C8C3DBBFB3FAF58822C34940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('4','H','E',NULL,NULL,'0105000000010000000102000000020000008624C0972433E0BF2EB9CB2756C0494031C48341C8C3DBBFB3FAF58822C34940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('5','H','S',NULL,NULL,'0105000000010000000102000000020000008624C0972433E0BF2EB9CB2756C0494072D67ECF5CE5DBBF3CDA892BEABA4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('6','D','H',NULL,NULL,'010500000001000000010200000002000000DE8360343D08E2BFE97AE863B6C349408624C0972433E0BF2EB9CB2756C04940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('7','K','J',NULL,NULL,'010500000001000000010200000002000000F7F9EA72C5D4DFBF86503A3EC4B74940A48D33B60C6CE2BF1048380ABCAB4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('8','J','I',NULL,NULL,'010500000001000000010200000002000000F7F9EA72C5D4DFBF86503A3EC4B74940349F48E9BE56DDBFED9C893D70AF4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('9','H','J',NULL,NULL,'010500000001000000010200000002000000F7F9EA72C5D4DFBF86503A3EC4B749408624C0972433E0BF2EB9CB2756C04940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('10','D','F','highway','highway','010500000001000000010200000002000000DE8360343D08E2BFE97AE863B6C34940DCEE6DA68678E2BFBAEC2F43A0B74940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('11','F','K','highway','highway','010500000001000000010200000002000000DCEE6DA68678E2BFBAEC2F43A0B74940A48D33B60C6CE2BF1048380ABCAB4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('12','K','L','highway','highway','010500000001000000010200000002000000A48D33B60C6CE2BF1048380ABCAB49405470BA309E40E1BF6A4499421BA54940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('13','L','M','highway','highway','0105000000010000000102000000020000005470BA309E40E1BF6A4499421BA54940A037D8AD4550DEBF4DCB13D4EFA34940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('14','M','V',NULL,NULL,'010500000001000000010200000002000000A037D8AD4550DEBF4DCB13D4EFA34940FE7D2E0BDFE7D6BF43F891048CA34940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('15','X','W',NULL,NULL,'01050000000100000001020000000200000018CF5F2E8A96D7BF257D7BC573D54940EDFBFE63467CD8BF819EDF7B21CA4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('16','N','A',NULL,NULL,'010500000001000000010200000002000000C8C7219F48E9E0BF4A38B21626E149408A3C029361BDE1BF0CA54EC88BD94940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('17','A','B',NULL,'noentry','0105000000010000000102000000020000008A3C029361BDE1BF0CA54EC88BD949401EA472CEDAC3E0BFC43E69AA8DD14940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('18','B','G',NULL,NULL,'0105000000010000000102000000020000001EA472CEDAC3E0BFC43E69AA8DD14940DCEE6DA68678E2BF4E5A53F0DFCC4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('19','G','P',NULL,NULL,'010500000001000000010200000002000000DCEE6DA68678E2BF4E5A53F0DFCC4940A04F6EF05A9BDEBF754CD6180BCA4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('20','P','E',NULL,NULL,'010500000001000000010200000002000000A04F6EF05A9BDEBF754CD6180BCA494031C48341C8C3DBBFB3FAF58822C34940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('21','S','T','noentry',NULL,'0105000000010000000102000000020000001AE31515A025DABF3E33B78CBBB1494072D67ECF5CE5DBBF3CDA892BEABA4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('22','T','U',NULL,NULL,'010500000001000000010200000002000000411DF83C06B5DABF818BF55226AB49401AE31515A025DABF3E33B78CBBB14940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('23','G','D',NULL,NULL,'010500000001000000010200000002000000DE8360343D08E2BFE97AE863B6C34940DCEE6DA68678E2BF4E5A53F0DFCC4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('24','O','C','highway','highway','01050000000100000001020000000200000083BCC16E2D82DEBFDB85C5BA98D749408C108CA607C1DCBF479759A5E2DB4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('25','N','O','highway','highway','0105000000010000000102000000020000008C108CA607C1DCBF479759A5E2DB4940C8C7219F48E9E0BF4A38B21626E14940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('26','N','Y',NULL,NULL,'010500000001000000010200000002000000C8C7219F48E9E0BF4A38B21626E1494018CF5F2E8A96D7BFC64EF12EF4E04940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('27','Y','Z',NULL,NULL,'01050000000100000001020000000200000018CF5F2E8A96D7BFC64EF12EF4E04940AF60B58570BCD5BFB8DA16EE4CDB4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('28','Z','X',NULL,NULL,'010500000001000000010200000002000000AF60B58570BCD5BFB8DA16EE4CDB494018CF5F2E8A96D7BF257D7BC573D54940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('29','C','Q','highway','highway','01050000000100000001020000000200000083BCC16E2D82DEBFDB85C5BA98D74940D05A835C129CDABF48282A92BFD14940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('30','X','Q',NULL,NULL,'010500000001000000010200000002000000D05A835C129CDABF48282A92BFD1494018CF5F2E8A96D7BF257D7BC573D54940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('31','I','U',NULL,NULL,'010500000001000000010200000002000000411DF83C06B5DABF818BF55226AB4940349F48E9BE56DDBFED9C893D70AF4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('32','U','V',NULL,NULL,'010500000001000000010200000002000000411DF83C06B5DABF818BF55226AB4940FE7D2E0BDFE7D6BF43F891048CA34940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('33','O','Z',NULL,NULL,'0105000000010000000102000000020000008C108CA607C1DCBF479759A5E2DB4940AF60B58570BCD5BFB8DA16EE4CDB4940');
INSERT INTO "graph2" (gid,"source_id","target_id","type","type_rev","the_geom") VALUES ('34','I','M',NULL,NULL,'010500000001000000010200000002000000349F48E9BE56DDBFED9C893D70AF4940A037D8AD4550DEBF4DCB13D4EFA34940');

ALTER TABLE ONLY "graph2" ADD CONSTRAINT "graph2_pkey" PRIMARY KEY (gid);
SELECT setval ('"graph2_gid_seq"', 34, true);
END;