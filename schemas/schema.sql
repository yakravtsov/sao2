--Role: pgsql

--DROP ROLE pgsql;

CREATE ROLE pgsql
LOGIN
INHERIT
CREATEDB
SUPERUSER
CREATEROLE
ENCRYPTED PASSWORD '******';

UPDATE pg_authid
SET rolcatupdate = true
WHERE (rolname = 'pgsql');
--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.0
-- Dumped by pg_dump version 9.4beta1
-- Started on 2015-02-01 19:20:2147483647
SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 173 (class 1259 OID 16393)
-- Name: history; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE history (
    created timestamp without time zone DEFAULT ('now'::text)::date,
    updated timestamp without time zone DEFAULT ('now'::text)::date,
    author_id integer NOT NULL
);


ALTER TABLE history OWNER TO saonline;

--
-- TOC entry 175 (class 1259 OID 16465)
-- Name: company; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE company (
    created timestamp without time zone DEFAULT ('now'::text)::date,
    updated timestamp without time zone DEFAULT ('now'::text)::date,
    author_id integer,
    company_id integer DEFAULT nextval(('public.company_id_seq'::text)::regclass) NOT NULL,
    name character varying(250) NOT NULL,
    parent_id integer DEFAULT 0 NOT NULL,
    level integer DEFAULT 0 NOT NULL
)
INHERITS (history);


ALTER TABLE company OWNER TO saonline;

--
-- TOC entry 186 (class 1259 OID 16605)
-- Name: company_id_seq; Type: SEQUENCE; Schema: public; Owner: saonline
--

CREATE SEQUENCE company_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE company_id_seq OWNER TO saonline;

--
-- TOC entry 194 (class 1259 OID 16817)
-- Name: competence; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE competence (
    competence_id integer NOT NULL,
    name character varying(255) NOT NULL,
    description text NOT NULL,
    code character(30) NOT NULL
)
INHERITS (history);


ALTER TABLE competence OWNER TO saonline;

--
-- TOC entry 193 (class 1259 OID 16815)
-- Name: competence_competence_id_seq; Type: SEQUENCE; Schema: public; Owner: saonline
--

CREATE SEQUENCE competence_competence_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE competence_competence_id_seq OWNER TO saonline;

--
-- TOC entry 2421 (class 0 OID 0)
-- Dependencies: 193
-- Name: competence_competence_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: saonline
--

ALTER SEQUENCE competence_competence_id_seq OWNED BY competence.competence_id;


--
-- TOC entry 190 (class 1259 OID 16745)
-- Name: feedback; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE feedback (
    feedback_id integer NOT NULL,
    email character varying(255) NOT NULL,
    name character varying(255),
    phone character varying(30),
    status integer DEFAULT 0 NOT NULL,
    text text
)
INHERITS (history);


ALTER TABLE feedback OWNER TO saonline;

--
-- TOC entry 192 (class 1259 OID 16760)
-- Name: feedback_answer; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE feedback_answer (
    feedback_answer_id integer NOT NULL,
    text text,
    feedback_id integer NOT NULL,
    email character varying(255)
)
INHERITS (history);


ALTER TABLE feedback_answer OWNER TO saonline;

--
-- TOC entry 191 (class 1259 OID 16758)
-- Name: feedback_answer_id_seq; Type: SEQUENCE; Schema: public; Owner: saonline
--

CREATE SEQUENCE feedback_answer_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE feedback_answer_id_seq OWNER TO saonline;

--
-- TOC entry 2422 (class 0 OID 0)
-- Dependencies: 191
-- Name: feedback_answer_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: saonline
--

ALTER SEQUENCE feedback_answer_id_seq OWNED BY feedback_answer.feedback_answer_id;


--
-- TOC entry 189 (class 1259 OID 16743)
-- Name: feedback_id_seq; Type: SEQUENCE; Schema: public; Owner: saonline
--

CREATE SEQUENCE feedback_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE feedback_id_seq OWNER TO saonline;

--
-- TOC entry 2423 (class 0 OID 0)
-- Dependencies: 189
-- Name: feedback_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: saonline
--

ALTER SEQUENCE feedback_id_seq OWNED BY feedback.feedback_id;


--
-- TOC entry 174 (class 1259 OID 16427)
-- Name: nested; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE nested (
    root integer,
    lft integer NOT NULL,
    rgt integer NOT NULL,
    depth integer NOT NULL
);


ALTER TABLE nested OWNER TO saonline;

--
-- TOC entry 176 (class 1259 OID 16491)
-- Name: project; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE project (
    project_id integer DEFAULT nextval(('public.projects_id_seq'::text)::regclass) NOT NULL,
    created timestamp without time zone DEFAULT ('now'::text)::date,
    updated timestamp without time zone DEFAULT ('now'::text)::date,
    author_id integer,
    date_start timestamp without time zone DEFAULT ('now'::text)::date NOT NULL,
    date_end timestamp without time zone DEFAULT ('now'::text)::date NOT NULL,
    report_type integer DEFAULT 0 NOT NULL,
    description text,
    notify integer DEFAULT 0 NOT NULL

)
INHERITS (history);


ALTER TABLE project OWNER TO saonline;

--
-- TOC entry 178 (class 1259 OID 16537)
-- Name: project_company; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE project_company (
    project_id integer DEFAULT 0 NOT NULL,
    company_id integer DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT ('now'::text)::date NOT NULL,
    updated timestamp without time zone DEFAULT ('now'::text)::date NOT NULL,
    author_id integer DEFAULT 0 NOT NULL
);


ALTER TABLE project_company OWNER TO saonline;

--
-- TOC entry 177 (class 1259 OID 16497)
-- Name: projects_id_seq; Type: SEQUENCE; Schema: public; Owner: saonline
--

CREATE SEQUENCE projects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE projects_id_seq OWNER TO saonline;

--
-- TOC entry 182 (class 1259 OID 16555)
-- Name: question; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE question (
    question_id integer NOT NULL,
    name character varying(255),
    type integer,
    test_id integer,
    root integer,
    lft integer,
    rgt integer,
    depth integer
)
INHERITS (history, nested);


ALTER TABLE question OWNER TO saonline;

--
-- TOC entry 181 (class 1259 OID 16553)
-- Name: question_id_seq; Type: SEQUENCE; Schema: public; Owner: saonline
--

CREATE SEQUENCE question_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE question_id_seq OWNER TO saonline;

--
-- TOC entry 2424 (class 0 OID 0)
-- Dependencies: 181
-- Name: question_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: saonline
--

ALTER SEQUENCE question_id_seq OWNED BY question.question_id;


--
-- TOC entry 183 (class 1259 OID 16563)
-- Name: question_scale; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE question_scale (
    question_id integer,
    scale_id integer,
    operation character varying(255),
    value integer
);


ALTER TABLE question_scale OWNER TO saonline;

--
-- TOC entry 185 (class 1259 OID 16590)
-- Name: scale; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE scale (
    scale_id integer NOT NULL,
    name character varying(255),
    test_id integer DEFAULT 0 NOT NULL,
    "default" integer DEFAULT 0 NOT NULL
)
INHERITS (history);


ALTER TABLE scale OWNER TO saonline;

--
-- TOC entry 184 (class 1259 OID 16588)
-- Name: scale_id_seq; Type: SEQUENCE; Schema: public; Owner: saonline
--

CREATE SEQUENCE scale_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE scale_id_seq OWNER TO saonline;

--
-- TOC entry 2425 (class 0 OID 0)
-- Dependencies: 184
-- Name: scale_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: saonline
--

ALTER SEQUENCE scale_id_seq OWNED BY scale.scale_id;


--
-- TOC entry 180 (class 1259 OID 16542)
-- Name: test; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE test (
    test_id integer NOT NULL,
    name character varying(255),
    description text,
    "order" integer,
    settings integer,
    deadline integer DEFAULT 0
)
INHERITS (history);


ALTER TABLE test OWNER TO saonline;

--
-- TOC entry 179 (class 1259 OID 16540)
-- Name: test_id_seq; Type: SEQUENCE; Schema: public; Owner: saonline
--

CREATE SEQUENCE test_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE test_id_seq OWNER TO saonline;

--
-- TOC entry 2426 (class 0 OID 0)
-- Dependencies: 179
-- Name: test_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: saonline
--

ALTER SEQUENCE test_id_seq OWNED BY test.test_id;


--
-- TOC entry 188 (class 1259 OID 16722)
-- Name: user; Type: TABLE; Schema: public; Owner: saonline; Tablespace: 
--

CREATE TABLE "user" (
    user_id integer NOT NULL,
    role_id integer DEFAULT 0 NOT NULL,
    parent_id integer DEFAULT 0 NOT NULL,
    email character varying(255) NOT NULL,
    phio character varying(255),
    company_id integer NOT NULL,
    last_login timestamp without time zone,
    status integer DEFAULT 1 NOT NULL,
    password_reset_token character varying(32),
    password_hash character varying(255) NOT NULL,
    login_hash character varying(255)
)
INHERITS (history);


ALTER TABLE "user" OWNER TO saonline;

--
-- TOC entry 187 (class 1259 OID 16720)
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: saonline
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE user_id_seq OWNER TO saonline;

--
-- TOC entry 2427 (class 0 OID 0)
-- Dependencies: 187
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: saonline
--

ALTER SEQUENCE user_id_seq OWNED BY "user".user_id;


--
-- TOC entry 2257 (class 2604 OID 16820)
-- Name: created; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY competence ALTER COLUMN created SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2258 (class 2604 OID 16821)
-- Name: updated; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY competence ALTER COLUMN updated SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2259 (class 2604 OID 16822)
-- Name: competence_id; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY competence ALTER COLUMN competence_id SET DEFAULT nextval('competence_competence_id_seq'::regclass);


--
-- TOC entry 2249 (class 2604 OID 16748)
-- Name: created; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY feedback ALTER COLUMN created SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2250 (class 2604 OID 16749)
-- Name: updated; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY feedback ALTER COLUMN updated SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2253 (class 2604 OID 16757)
-- Name: author_id; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY feedback ALTER COLUMN author_id SET DEFAULT 0;


--
-- TOC entry 2251 (class 2604 OID 16750)
-- Name: feedback_id; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY feedback ALTER COLUMN feedback_id SET DEFAULT nextval('feedback_id_seq'::regclass);


--
-- TOC entry 2254 (class 2604 OID 16763)
-- Name: created; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY feedback_answer ALTER COLUMN created SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2255 (class 2604 OID 16764)
-- Name: updated; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY feedback_answer ALTER COLUMN updated SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2256 (class 2604 OID 16765)
-- Name: feedback_answer_id; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY feedback_answer ALTER COLUMN feedback_answer_id SET DEFAULT nextval('feedback_answer_id_seq'::regclass);


--
-- TOC entry 2235 (class 2604 OID 16558)
-- Name: created; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY question ALTER COLUMN created SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2236 (class 2604 OID 16559)
-- Name: updated; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY question ALTER COLUMN updated SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2237 (class 2604 OID 16560)
-- Name: question_id; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY question ALTER COLUMN question_id SET DEFAULT nextval('question_id_seq'::regclass);


--
-- TOC entry 2238 (class 2604 OID 16593)
-- Name: created; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY scale ALTER COLUMN created SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2239 (class 2604 OID 16594)
-- Name: updated; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY scale ALTER COLUMN updated SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2240 (class 2604 OID 16595)
-- Name: scale_id; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY scale ALTER COLUMN scale_id SET DEFAULT nextval('scale_id_seq'::regclass);


--
-- TOC entry 2231 (class 2604 OID 16545)
-- Name: created; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY test ALTER COLUMN created SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2232 (class 2604 OID 16546)
-- Name: updated; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY test ALTER COLUMN updated SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2233 (class 2604 OID 16547)
-- Name: test_id; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY test ALTER COLUMN test_id SET DEFAULT nextval('test_id_seq'::regclass);


--
-- TOC entry 2243 (class 2604 OID 16725)
-- Name: created; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY "user" ALTER COLUMN created SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2244 (class 2604 OID 16726)
-- Name: updated; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY "user" ALTER COLUMN updated SET DEFAULT ('now'::text)::date;


--
-- TOC entry 2245 (class 2604 OID 16727)
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY "user" ALTER COLUMN user_id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- TOC entry 2395 (class 0 OID 16465)
-- Dependencies: 175
-- Data for Name: company; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY company (created, updated, author_id, company_id, name, parent_id, level) FROM stdin;
2015-01-21 01:10:55.232	2015-01-23 03:31:36.57755	2	4	О2	2	0
2015-01-21 00:25:57.679	2015-01-23 03:32:26.116552	2	3	ОООшечка	2	0
2015-01-20 22:44:52.597	2015-01-23 03:32:32.265393	2	2	Mota-systems	0	0
2015-01-20 22:33:13.008	2015-01-29 20:50:31.386714	2	1	Bitobe	0	0
\.


--
-- TOC entry 2428 (class 0 OID 0)
-- Dependencies: 186
-- Name: company_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saonline
--

SELECT pg_catalog.setval('company_id_seq', 1, false);


--
-- TOC entry 2414 (class 0 OID 16817)
-- Dependencies: 194
-- Data for Name: competence; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY competence (created, updated, author_id, competence_id, name, description, code) FROM stdin;
\.


--
-- TOC entry 2429 (class 0 OID 0)
-- Dependencies: 193
-- Name: competence_competence_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saonline
--

SELECT pg_catalog.setval('competence_competence_id_seq', 1, false);


--
-- TOC entry 2410 (class 0 OID 16745)
-- Dependencies: 190
-- Data for Name: feedback; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY feedback (created, updated, author_id, feedback_id, email, name, phone, status, text) FROM stdin;
2015-02-01 03:18:11.403606	2015-02-01 03:18:11.403606	1	27	yakravtsov@gmail.com	Кравцов Даниил	+79111111111	0	Новое сообщение в техподдержку.
2015-01-27 02:31:16.348994	2015-02-01 04:19:23.340806	1	2	test@email.ru	Валера	Телефон	1	фывайцкр
2015-01-31 23:09:27.088994	2015-02-01 04:38:04.978696	0	26	test@email.ru	asfd	q	1	rg
2015-01-27 03:37:51.940303	2015-02-01 12:57:32.541859	1	5	yakravtov@gmail.com	Даниил	+79111111111	1	Здравствуйте. Не могу войти в раздел тестирования, что мне делать?
2015-01-27 19:23:08.312423	2015-02-01 18:42:28.650448	1	6	yakravtsov@gmail.com	Кравцов Даниил		1	Пробую
\.


--
-- TOC entry 2412 (class 0 OID 16760)
-- Dependencies: 192
-- Data for Name: feedback_answer; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY feedback_answer (created, updated, author_id, feedback_answer_id, text, feedback_id, email) FROM stdin;
2015-02-01 02:14:33.199118	2015-02-01 02:14:33.199118	1	3	Я вам говорю — всё вы можете!	6	yakravtsov@gmail.com
2015-02-01 02:15:04.495368	2015-02-01 02:15:04.495368	1	4	Абсолютно всё!	6	yakravtsov@gmail.com
2015-02-01 03:58:21.572436	2015-02-01 03:58:21.572436	1	5	Выражайте свои мысли яснее, пожалуйста.	2	test@email.ru
2015-02-01 04:19:23.329269	2015-02-01 04:19:23.329269	1	6	фывавйцкуа	2	test@email.ru
2015-02-01 12:57:32.521759	2015-02-01 12:57:32.521759	1	7	Не делайте ничего.	5	yakravtov@gmail.com
2015-02-01 18:42:28.634015	2015-02-01 18:42:28.634015	1	8	чвкнлвкгдскегдса	6	yakravtsov@gmail.com
\.


--
-- TOC entry 2430 (class 0 OID 0)
-- Dependencies: 191
-- Name: feedback_answer_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saonline
--

SELECT pg_catalog.setval('feedback_answer_id_seq', 8, true);


--
-- TOC entry 2431 (class 0 OID 0)
-- Dependencies: 189
-- Name: feedback_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saonline
--

SELECT pg_catalog.setval('feedback_id_seq', 27, true);


--
-- TOC entry 2393 (class 0 OID 16393)
-- Dependencies: 173
-- Data for Name: history; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY history (created, updated, author_id) FROM stdin;
\.


--
-- TOC entry 2394 (class 0 OID 16427)
-- Dependencies: 174
-- Data for Name: nested; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY nested (root, lft, rgt, depth) FROM stdin;
\.


--
-- TOC entry 2396 (class 0 OID 16491)
-- Dependencies: 176
-- Data for Name: project; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY project (project_id, created, updated, author_id, date_start, date_end, report_type, description, notify) FROM stdin;
\.


--
-- TOC entry 2398 (class 0 OID 16537)
-- Dependencies: 178
-- Data for Name: project_company; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY project_company (project_id, company_id, created, updated, author_id) FROM stdin;
\.


--
-- TOC entry 2432 (class 0 OID 0)
-- Dependencies: 177
-- Name: projects_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saonline
--

SELECT pg_catalog.setval('projects_id_seq', 1, false);


--
-- TOC entry 2402 (class 0 OID 16555)
-- Dependencies: 182
-- Data for Name: question; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY question (created, updated, author_id, question_id, name, type, test_id, root, lft, rgt, depth) FROM stdin;
\.


--
-- TOC entry 2433 (class 0 OID 0)
-- Dependencies: 181
-- Name: question_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saonline
--

SELECT pg_catalog.setval('question_id_seq', 1, false);


--
-- TOC entry 2403 (class 0 OID 16563)
-- Dependencies: 183
-- Data for Name: question_scale; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY question_scale (question_id, scale_id, operation, value) FROM stdin;
\.


--
-- TOC entry 2405 (class 0 OID 16590)
-- Dependencies: 185
-- Data for Name: scale; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY scale (created, updated, author_id, scale_id, name, test_id, "default") FROM stdin;
\.


--
-- TOC entry 2434 (class 0 OID 0)
-- Dependencies: 184
-- Name: scale_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saonline
--

SELECT pg_catalog.setval('scale_id_seq', 1, false);


--
-- TOC entry 2400 (class 0 OID 16542)
-- Dependencies: 180
-- Data for Name: test; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY test (created, updated, author_id, test_id, name, description, "order", settings, deadline) FROM stdin;
\.


--
-- TOC entry 2435 (class 0 OID 0)
-- Dependencies: 179
-- Name: test_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saonline
--

SELECT pg_catalog.setval('test_id_seq', 1, false);


--
-- TOC entry 2408 (class 0 OID 16722)
-- Dependencies: 188
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: saonline
--

COPY "user" (created, updated, author_id, user_id, role_id, parent_id, email, phio, company_id, last_login, status, password_reset_token, password_hash, login_hash) FROM stdin;
2015-01-20 09:30:14	2015-01-21 01:15:43	0	1	0	0	yakravtsov@gmail.com	Кравцов Даниил	1	\N	1	\N	$2y$13$cpOAQ3QFd8tD4CTsN3QHRutPPl8IZrjXE2TtDIz2CgSFtejOEjd22	\N
2015-01-23 04:26:46.304115	2015-01-23 04:26:46.304115	1	2	2	0	tesaaagqter@email.ru	asfdqwr	1	\N	1	\N	$2y$13$muj1GZmxO0kom5pNJ5kj8.MpW5uCpJJnoMV21./kXZOrW2GNpWhpq	\N
2015-01-23 04:27:04.539035	2015-01-23 04:27:04.539035	1	3	4	0	testeqrqr@email.ru	qwrgqwr	1	\N	1	\N	$2y$13$lBpsB1OeCTISxxKGoXhjIOMx2Va26UvXYAee4T9qFCMn3/yNcQNQ6	\N
2015-01-23 04:24:04.528488	2015-01-23 04:30:10.560744	1	0	2	0	atester@email.ru	валера	3	\N	1	\N	$2y$13$SaUXABpK21w8KQIY1vUYNemXTYqsgfRz34PU7PgOscbmFGNAGGBay	\N
2015-01-26 16:12:47.130913	2015-01-26 16:12:47.130913	1	4	2	0	andrey_govno@email.ru	Андрей говно	3	\N	1	\N	$2y$13$Bfst20576tQo3cjURaYrkOP1P.HE2It7x.ype8ktb2YR3J2WFbNnG	c6f1c422b6c9f012ea42d3a019e829a8f63cfba7
\.


--
-- TOC entry 2436 (class 0 OID 0)
-- Dependencies: 187
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saonline
--

SELECT pg_catalog.setval('user_id_seq', 7, true);


--
-- TOC entry 2261 (class 2606 OID 16608)
-- Name: company_pkey1; Type: CONSTRAINT; Schema: public; Owner: saonline; Tablespace: 
--

ALTER TABLE ONLY company
    ADD CONSTRAINT company_pkey1 PRIMARY KEY (company_id);


--
-- TOC entry 2279 (class 2606 OID 16827)
-- Name: competence_pkey; Type: CONSTRAINT; Schema: public; Owner: saonline; Tablespace: 
--

ALTER TABLE ONLY competence
    ADD CONSTRAINT competence_pkey PRIMARY KEY (competence_id);


--
-- TOC entry 2271 (class 2606 OID 16742)
-- Name: email; Type: CONSTRAINT; Schema: public; Owner: saonline; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT email UNIQUE (email);


--
-- TOC entry 2277 (class 2606 OID 16770)
-- Name: feedback_answer_pkey; Type: CONSTRAINT; Schema: public; Owner: saonline; Tablespace: 
--

ALTER TABLE ONLY feedback_answer
    ADD CONSTRAINT feedback_answer_pkey PRIMARY KEY (feedback_answer_id);


--
-- TOC entry 2275 (class 2606 OID 16756)
-- Name: feedback_pkey; Type: CONSTRAINT; Schema: public; Owner: saonline; Tablespace: 
--

ALTER TABLE ONLY feedback
    ADD CONSTRAINT feedback_pkey PRIMARY KEY (feedback_id);


--
-- TOC entry 2263 (class 2606 OID 16501)
-- Name: projects_pkey; Type: CONSTRAINT; Schema: public; Owner: saonline; Tablespace: 
--

ALTER TABLE ONLY project
    ADD CONSTRAINT projects_pkey PRIMARY KEY (project_id);


--
-- TOC entry 2267 (class 2606 OID 16562)
-- Name: question_pkey; Type: CONSTRAINT; Schema: public; Owner: saonline; Tablespace: 
--

ALTER TABLE ONLY question
    ADD CONSTRAINT question_pkey PRIMARY KEY (question_id);


--
-- TOC entry 2269 (class 2606 OID 16599)
-- Name: scale_pkey; Type: CONSTRAINT; Schema: public; Owner: saonline; Tablespace: 
--

ALTER TABLE ONLY scale
    ADD CONSTRAINT scale_pkey PRIMARY KEY (scale_id);


--
-- TOC entry 2265 (class 2606 OID 16552)
-- Name: test_pkey; Type: CONSTRAINT; Schema: public; Owner: saonline; Tablespace: 
--

ALTER TABLE ONLY test
    ADD CONSTRAINT test_pkey PRIMARY KEY (test_id);


--
-- TOC entry 2273 (class 2606 OID 16735)
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: saonline; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (user_id);


--
-- TOC entry 2284 (class 2606 OID 16736)
-- Name: company; Type: FK CONSTRAINT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT company FOREIGN KEY (company_id) REFERENCES company(company_id);


--
-- TOC entry 2281 (class 2606 OID 16786)
-- Name: foreign_key01; Type: FK CONSTRAINT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY question
    ADD CONSTRAINT foreign_key01 FOREIGN KEY (test_id) REFERENCES test(test_id) ON UPDATE CASCADE ON DELETE CASCADE DEFERRABLE;


--
-- TOC entry 2282 (class 2606 OID 16791)
-- Name: foreign_key01; Type: FK CONSTRAINT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY question_scale
    ADD CONSTRAINT foreign_key01 FOREIGN KEY (question_id) REFERENCES question(question_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2283 (class 2606 OID 16801)
-- Name: foreign_key01; Type: FK CONSTRAINT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY scale
    ADD CONSTRAINT foreign_key01 FOREIGN KEY (test_id) REFERENCES test(test_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2280 (class 2606 OID 16771)
-- Name: history_user; Type: FK CONSTRAINT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY history
    ADD CONSTRAINT history_user FOREIGN KEY (author_id) REFERENCES "user"(user_id);


--
-- TOC entry 2285 (class 2606 OID 16781)
-- Name: question_answer; Type: FK CONSTRAINT; Schema: public; Owner: saonline
--

ALTER TABLE ONLY feedback_answer
    ADD CONSTRAINT question_answer FOREIGN KEY (feedback_id) REFERENCES feedback(feedback_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2420 (class 0 OID 0)
-- Dependencies: 7
-- Name: public; Type: ACL; Schema: -; Owner: pgsql
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM pgsql;
GRANT ALL ON SCHEMA public TO pgsql;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2015-02-01 19:20:29

--
-- PostgreSQL database dump complete
--

