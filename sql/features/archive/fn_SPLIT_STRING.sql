/* nur fuer Entwicklung verwendet, fuer Anwendung nicht notwendig */ 
CREATE FUNCTION fn_SPLIT_STRING(str VARCHAR(255), delim VARCHAR(12), pos INT)
RETURNS VARCHAR(255)
RETURN TRIM(REPLACE(SUBSTRING(SUBSTRING_INDEX(str, delim, pos),
    CHAR_LENGTH(SUBSTRING_INDEX(str, delim, pos-1)) + 1),delim, ''))