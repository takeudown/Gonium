--
-- PostgreSQL database dump
--

-- Started on 2009-02-23 05:02:44

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1492 (class 1259 OID 17792)
-- Dependencies: 6
-- Name: rox_core_acl_access; Type: TABLE; Schema: public; Owner: roxyton; Tablespace: 
--

CREATE TABLE rox_core_acl_access (
    rule_id integer NOT NULL,
    role_id character varying(50),
    resource_name character varying(50),
    privilege character varying(50),
    allow smallint
);


ALTER TABLE public.rox_core_acl_access OWNER TO roxyton;

--
-- TOC entry 1493 (class 1259 OID 17795)
-- Dependencies: 6
-- Name: rox_core_acl_inheritance; Type: TABLE; Schema: public; Owner: roxyton; Tablespace: 
--

CREATE TABLE rox_core_acl_inheritance (
    inheritance_id integer NOT NULL,
    role_id character varying(50),
    parent_id character varying(50),
    priority integer
);


ALTER TABLE public.rox_core_acl_inheritance OWNER TO roxyton;

--
-- TOC entry 1494 (class 1259 OID 17798)
-- Dependencies: 6
-- Name: rox_core_acl_resources; Type: TABLE; Schema: public; Owner: roxyton; Tablespace: 
--

CREATE TABLE rox_core_acl_resources (
    resource_id integer NOT NULL,
    parent_id integer,
    resource_name character varying(50) NOT NULL,
    privilege character varying(50),
    scope character varying(50)
);


ALTER TABLE public.rox_core_acl_resources OWNER TO roxyton;

--
-- TOC entry 1495 (class 1259 OID 17801)
-- Dependencies: 6
-- Name: rox_core_acl_roles; Type: TABLE; Schema: public; Owner: roxyton; Tablespace: 
--

CREATE TABLE rox_core_acl_roles (
    role_id character varying(50) NOT NULL
);


ALTER TABLE public.rox_core_acl_roles OWNER TO roxyton;

--
-- TOC entry 1496 (class 1259 OID 17804)
-- Dependencies: 6
-- Name: rox_core_modules; Type: TABLE; Schema: public; Owner: roxyton; Tablespace: 
--

CREATE TABLE rox_core_modules (
    directory character varying(50) NOT NULL,
    name character varying(50),
    resource_id integer
);


ALTER TABLE public.rox_core_modules OWNER TO roxyton;

--
-- TOC entry 1497 (class 1259 OID 17807)
-- Dependencies: 6
-- Name: rox_core_user_profile; Type: TABLE; Schema: public; Owner: roxyton; Tablespace: 
--

CREATE TABLE rox_core_user_profile (
    uid integer NOT NULL,
    email character varying(100) NOT NULL,
    name character varying(200),
    web character varying(200)
);


ALTER TABLE public.rox_core_user_profile OWNER TO roxyton;

--
-- TOC entry 1498 (class 1259 OID 17813)
-- Dependencies: 6
-- Name: rox_core_users; Type: TABLE; Schema: public; Owner: roxyton; Tablespace: 
--

CREATE TABLE rox_core_users (
    uid integer NOT NULL,
    username character varying(100),
    password character varying(100),
    role_id character varying(50) NOT NULL
);


ALTER TABLE public.rox_core_users OWNER TO roxyton;

--
-- TOC entry 1499 (class 1259 OID 17816)
-- Dependencies: 6
-- Name: rox_core_widgets; Type: TABLE; Schema: public; Owner: roxyton; Tablespace: 
--

CREATE TABLE rox_core_widgets (
    widget_id integer NOT NULL,
    resource_id integer NOT NULL,
    title character varying(60),
    rox_block character varying(60),
    rox_position character varying(30)
);


ALTER TABLE public.rox_core_widgets OWNER TO roxyton;

--
-- TOC entry 1500 (class 1259 OID 17819)
-- Dependencies: 6
-- Name: rox_mod_blog_comments; Type: TABLE; Schema: public; Owner: roxyton; Tablespace: 
--

CREATE TABLE rox_mod_blog_comments (
    comment_id integer NOT NULL,
    post_id integer NOT NULL,
    uid integer,
    comment_name character varying(200),
    comment_email character varying(200),
    comment_website character varying(200),
    comment_text text
);


ALTER TABLE public.rox_mod_blog_comments OWNER TO roxyton;

--
-- TOC entry 1501 (class 1259 OID 17825)
-- Dependencies: 6
-- Name: rox_mod_blog_posts; Type: TABLE; Schema: public; Owner: roxyton; Tablespace: 
--

CREATE TABLE rox_mod_blog_posts (
    post_id integer NOT NULL,
    post_title character varying(200),
    post_text text,
    post_permalink character varying(200),
    uid integer
);


ALTER TABLE public.rox_mod_blog_posts OWNER TO roxyton;

--
-- TOC entry 1502 (class 1259 OID 17831)
-- Dependencies: 1492 6
-- Name: rox_core_acl_access_rule_id_seq; Type: SEQUENCE; Schema: public; Owner: roxyton
--

CREATE SEQUENCE rox_core_acl_access_rule_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.rox_core_acl_access_rule_id_seq OWNER TO roxyton;

--
-- TOC entry 1836 (class 0 OID 0)
-- Dependencies: 1502
-- Name: rox_core_acl_access_rule_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roxyton
--

ALTER SEQUENCE rox_core_acl_access_rule_id_seq OWNED BY rox_core_acl_access.rule_id;


--
-- TOC entry 1837 (class 0 OID 0)
-- Dependencies: 1502
-- Name: rox_core_acl_access_rule_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roxyton
--

SELECT pg_catalog.setval('rox_core_acl_access_rule_id_seq', 1, false);


--
-- TOC entry 1503 (class 1259 OID 17833)
-- Dependencies: 6 1493
-- Name: rox_core_acl_inheritance_inheritance_id_seq; Type: SEQUENCE; Schema: public; Owner: roxyton
--

CREATE SEQUENCE rox_core_acl_inheritance_inheritance_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.rox_core_acl_inheritance_inheritance_id_seq OWNER TO roxyton;

--
-- TOC entry 1838 (class 0 OID 0)
-- Dependencies: 1503
-- Name: rox_core_acl_inheritance_inheritance_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roxyton
--

ALTER SEQUENCE rox_core_acl_inheritance_inheritance_id_seq OWNED BY rox_core_acl_inheritance.inheritance_id;


--
-- TOC entry 1839 (class 0 OID 0)
-- Dependencies: 1503
-- Name: rox_core_acl_inheritance_inheritance_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roxyton
--

SELECT pg_catalog.setval('rox_core_acl_inheritance_inheritance_id_seq', 1, false);


--
-- TOC entry 1504 (class 1259 OID 17835)
-- Dependencies: 1494 6
-- Name: rox_core_acl_resources_resource_id_seq; Type: SEQUENCE; Schema: public; Owner: roxyton
--

CREATE SEQUENCE rox_core_acl_resources_resource_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.rox_core_acl_resources_resource_id_seq OWNER TO roxyton;

--
-- TOC entry 1840 (class 0 OID 0)
-- Dependencies: 1504
-- Name: rox_core_acl_resources_resource_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roxyton
--

ALTER SEQUENCE rox_core_acl_resources_resource_id_seq OWNED BY rox_core_acl_resources.resource_id;


--
-- TOC entry 1841 (class 0 OID 0)
-- Dependencies: 1504
-- Name: rox_core_acl_resources_resource_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roxyton
--

SELECT pg_catalog.setval('rox_core_acl_resources_resource_id_seq', 1, false);


--
-- TOC entry 1505 (class 1259 OID 17837)
-- Dependencies: 6 1495
-- Name: rox_core_acl_roles_role_id_seq; Type: SEQUENCE; Schema: public; Owner: roxyton
--

CREATE SEQUENCE rox_core_acl_roles_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.rox_core_acl_roles_role_id_seq OWNER TO roxyton;

--
-- TOC entry 1842 (class 0 OID 0)
-- Dependencies: 1505
-- Name: rox_core_acl_roles_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roxyton
--

ALTER SEQUENCE rox_core_acl_roles_role_id_seq OWNED BY rox_core_acl_roles.role_id;


--
-- TOC entry 1843 (class 0 OID 0)
-- Dependencies: 1505
-- Name: rox_core_acl_roles_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roxyton
--

SELECT pg_catalog.setval('rox_core_acl_roles_role_id_seq', 1, false);


--
-- TOC entry 1506 (class 1259 OID 17839)
-- Dependencies: 1498 6
-- Name: rox_core_users_uid_seq; Type: SEQUENCE; Schema: public; Owner: roxyton
--

CREATE SEQUENCE rox_core_users_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.rox_core_users_uid_seq OWNER TO roxyton;

--
-- TOC entry 1844 (class 0 OID 0)
-- Dependencies: 1506
-- Name: rox_core_users_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roxyton
--

ALTER SEQUENCE rox_core_users_uid_seq OWNED BY rox_core_users.uid;


--
-- TOC entry 1845 (class 0 OID 0)
-- Dependencies: 1506
-- Name: rox_core_users_uid_seq; Type: SEQUENCE SET; Schema: public; Owner: roxyton
--

SELECT pg_catalog.setval('rox_core_users_uid_seq', 1, false);


--
-- TOC entry 1507 (class 1259 OID 17841)
-- Dependencies: 6 1499
-- Name: rox_core_widgets_widget_id_seq; Type: SEQUENCE; Schema: public; Owner: roxyton
--

CREATE SEQUENCE rox_core_widgets_widget_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.rox_core_widgets_widget_id_seq OWNER TO roxyton;

--
-- TOC entry 1846 (class 0 OID 0)
-- Dependencies: 1507
-- Name: rox_core_widgets_widget_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roxyton
--

ALTER SEQUENCE rox_core_widgets_widget_id_seq OWNED BY rox_core_widgets.widget_id;


--
-- TOC entry 1847 (class 0 OID 0)
-- Dependencies: 1507
-- Name: rox_core_widgets_widget_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roxyton
--

SELECT pg_catalog.setval('rox_core_widgets_widget_id_seq', 1, false);


--
-- TOC entry 1508 (class 1259 OID 17843)
-- Dependencies: 1500 6
-- Name: rox_mod_blog_comments_comment_id_seq; Type: SEQUENCE; Schema: public; Owner: roxyton
--

CREATE SEQUENCE rox_mod_blog_comments_comment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.rox_mod_blog_comments_comment_id_seq OWNER TO roxyton;

--
-- TOC entry 1848 (class 0 OID 0)
-- Dependencies: 1508
-- Name: rox_mod_blog_comments_comment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roxyton
--

ALTER SEQUENCE rox_mod_blog_comments_comment_id_seq OWNED BY rox_mod_blog_comments.comment_id;


--
-- TOC entry 1849 (class 0 OID 0)
-- Dependencies: 1508
-- Name: rox_mod_blog_comments_comment_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roxyton
--

SELECT pg_catalog.setval('rox_mod_blog_comments_comment_id_seq', 1, false);


--
-- TOC entry 1509 (class 1259 OID 17845)
-- Dependencies: 1501 6
-- Name: rox_mod_blog_posts_post_id_seq; Type: SEQUENCE; Schema: public; Owner: roxyton
--

CREATE SEQUENCE rox_mod_blog_posts_post_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.rox_mod_blog_posts_post_id_seq OWNER TO roxyton;

--
-- TOC entry 1850 (class 0 OID 0)
-- Dependencies: 1509
-- Name: rox_mod_blog_posts_post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roxyton
--

ALTER SEQUENCE rox_mod_blog_posts_post_id_seq OWNED BY rox_mod_blog_posts.post_id;


--
-- TOC entry 1851 (class 0 OID 0)
-- Dependencies: 1509
-- Name: rox_mod_blog_posts_post_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roxyton
--

SELECT pg_catalog.setval('rox_mod_blog_posts_post_id_seq', 1, false);


--
-- TOC entry 1776 (class 2604 OID 17847)
-- Dependencies: 1502 1492
-- Name: rule_id; Type: DEFAULT; Schema: public; Owner: roxyton
--

ALTER TABLE rox_core_acl_access ALTER COLUMN rule_id SET DEFAULT nextval('rox_core_acl_access_rule_id_seq'::regclass);


--
-- TOC entry 1777 (class 2604 OID 17848)
-- Dependencies: 1503 1493
-- Name: inheritance_id; Type: DEFAULT; Schema: public; Owner: roxyton
--

ALTER TABLE rox_core_acl_inheritance ALTER COLUMN inheritance_id SET DEFAULT nextval('rox_core_acl_inheritance_inheritance_id_seq'::regclass);


--
-- TOC entry 1778 (class 2604 OID 17849)
-- Dependencies: 1504 1494
-- Name: resource_id; Type: DEFAULT; Schema: public; Owner: roxyton
--

ALTER TABLE rox_core_acl_resources ALTER COLUMN resource_id SET DEFAULT nextval('rox_core_acl_resources_resource_id_seq'::regclass);


--
-- TOC entry 1779 (class 2604 OID 17850)
-- Dependencies: 1505 1495
-- Name: role_id; Type: DEFAULT; Schema: public; Owner: roxyton
--

ALTER TABLE rox_core_acl_roles ALTER COLUMN role_id SET DEFAULT nextval('rox_core_acl_roles_role_id_seq'::regclass);


--
-- TOC entry 1780 (class 2604 OID 17851)
-- Dependencies: 1506 1498
-- Name: uid; Type: DEFAULT; Schema: public; Owner: roxyton
--

ALTER TABLE rox_core_users ALTER COLUMN uid SET DEFAULT nextval('rox_core_users_uid_seq'::regclass);


--
-- TOC entry 1781 (class 2604 OID 17852)
-- Dependencies: 1507 1499
-- Name: widget_id; Type: DEFAULT; Schema: public; Owner: roxyton
--

ALTER TABLE rox_core_widgets ALTER COLUMN widget_id SET DEFAULT nextval('rox_core_widgets_widget_id_seq'::regclass);


--
-- TOC entry 1782 (class 2604 OID 17853)
-- Dependencies: 1508 1500
-- Name: comment_id; Type: DEFAULT; Schema: public; Owner: roxyton
--

ALTER TABLE rox_mod_blog_comments ALTER COLUMN comment_id SET DEFAULT nextval('rox_mod_blog_comments_comment_id_seq'::regclass);


--
-- TOC entry 1783 (class 2604 OID 17854)
-- Dependencies: 1509 1501
-- Name: post_id; Type: DEFAULT; Schema: public; Owner: roxyton
--

ALTER TABLE rox_mod_blog_posts ALTER COLUMN post_id SET DEFAULT nextval('rox_mod_blog_posts_post_id_seq'::regclass);


--
-- TOC entry 1822 (class 0 OID 17792)
-- Dependencies: 1492
-- Data for Name: rox_core_acl_access; Type: TABLE DATA; Schema: public; Owner: roxyton
--

INSERT INTO rox_core_acl_access (rule_id, role_id, resource_name, privilege, allow) VALUES (8, 'Writers', 'Printer', NULL, 1);
INSERT INTO rox_core_acl_access (rule_id, role_id, resource_name, privilege, allow) VALUES (9, 'Writers', 'TextWritingProggie', NULL, 1);
INSERT INTO rox_core_acl_access (rule_id, role_id, resource_name, privilege, allow) VALUES (10, 'Editors', 'TextWritingProggie', NULL, 1);
INSERT INTO rox_core_acl_access (rule_id, role_id, resource_name, privilege, allow) VALUES (11, 'Admins', NULL, NULL, 1);
INSERT INTO rox_core_acl_access (rule_id, role_id, resource_name, privilege, allow) VALUES (12, 'Editors', 'svn', NULL, 1);
INSERT INTO rox_core_acl_access (rule_id, role_id, resource_name, privilege, allow) VALUES (13, 'Writers', 'svn', NULL, 1);
INSERT INTO rox_core_acl_access (rule_id, role_id, resource_name, privilege, allow) VALUES (14, 'Publishers', 'PhoneBook', NULL, 1);
INSERT INTO rox_core_acl_access (rule_id, role_id, resource_name, privilege, allow) VALUES (15, 'Publishers', 'svn', NULL, 1);
INSERT INTO rox_core_acl_access (rule_id, role_id, resource_name, privilege, allow) VALUES (16, 'Publishers', 'svn', 'commit', 0);


--
-- TOC entry 1823 (class 0 OID 17795)
-- Dependencies: 1493
-- Data for Name: rox_core_acl_inheritance; Type: TABLE DATA; Schema: public; Owner: roxyton
--



--
-- TOC entry 1824 (class 0 OID 17798)
-- Dependencies: 1494
-- Data for Name: rox_core_acl_resources; Type: TABLE DATA; Schema: public; Owner: roxyton
--

INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (8, NULL, 'svn', 'checkout', 'system');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (9, NULL, 'svn', 'commit', 'system');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (10, NULL, 'svn', 'update', 'system');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (1, NULL, 'default', NULL, 'module');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (2, NULL, 'home', NULL, 'system');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (3, NULL, 'mod_blog', NULL, 'module');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (4, NULL, 'mod_default', NULL, 'module');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (5, NULL, 'mod_tienda', NULL, 'module');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (6, NULL, 'PhoneBook', NULL, 'system');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (7, NULL, 'Printer', NULL, 'system');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (11, NULL, 'TextWritingProggie', NULL, 'system');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (12, 2, 'bathroom', NULL, 'system');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (13, 11, 'LaTeX', NULL, 'system');
INSERT INTO rox_core_acl_resources (resource_id, parent_id, resource_name, privilege, scope) VALUES (14, 11, 'OOfficeWriter', NULL, 'system');


--
-- TOC entry 1825 (class 0 OID 17801)
-- Dependencies: 1495
-- Data for Name: rox_core_acl_roles; Type: TABLE DATA; Schema: public; Owner: roxyton
--

INSERT INTO rox_core_acl_roles (role_id) VALUES ('Admins');
INSERT INTO rox_core_acl_roles (role_id) VALUES ('Editors');
INSERT INTO rox_core_acl_roles (role_id) VALUES ('Publishers');
INSERT INTO rox_core_acl_roles (role_id) VALUES ('some.editor@example.org');
INSERT INTO rox_core_acl_roles (role_id) VALUES ('some.publisher@example.org');
INSERT INTO rox_core_acl_roles (role_id) VALUES ('some.writer@example.org');
INSERT INTO rox_core_acl_roles (role_id) VALUES ('uberadmin@example.org');
INSERT INTO rox_core_acl_roles (role_id) VALUES ('Writers');
INSERT INTO rox_core_acl_roles (role_id) VALUES ('Guest');


--
-- TOC entry 1826 (class 0 OID 17804)
-- Dependencies: 1496
-- Data for Name: rox_core_modules; Type: TABLE DATA; Schema: public; Owner: roxyton
--



--
-- TOC entry 1827 (class 0 OID 17807)
-- Dependencies: 1497
-- Data for Name: rox_core_user_profile; Type: TABLE DATA; Schema: public; Owner: roxyton
--



--
-- TOC entry 1828 (class 0 OID 17813)
-- Dependencies: 1498
-- Data for Name: rox_core_users; Type: TABLE DATA; Schema: public; Owner: roxyton
--

INSERT INTO rox_core_users (uid, username, password, role_id) VALUES (0, 'Anonymous', '', 'Guest');
INSERT INTO rox_core_users (uid, username, password, role_id) VALUES (1, 'admin', '320d1a474a0dece4a7fac9136406fd6d63d62ec5', 'Admins');
INSERT INTO rox_core_users (uid, username, password, role_id) VALUES (2, 'some.editor', 'a444c6174a11913f69916d4486083e909f2e516f', 'Editors');
INSERT INTO rox_core_users (uid, username, password, role_id) VALUES (3, 'some.publisher', 'd791aad38ccd7dc598178e90493f72cd6949881e', 'Publishers');
INSERT INTO rox_core_users (uid, username, password, role_id) VALUES (4, 'some.writer', 'bf9f2de4daf079aebd44a68261579bde1a09dc52', 'Writers');


--
-- TOC entry 1829 (class 0 OID 17816)
-- Dependencies: 1499
-- Data for Name: rox_core_widgets; Type: TABLE DATA; Schema: public; Owner: roxyton
--



--
-- TOC entry 1830 (class 0 OID 17819)
-- Dependencies: 1500
-- Data for Name: rox_mod_blog_comments; Type: TABLE DATA; Schema: public; Owner: roxyton
--



--
-- TOC entry 1831 (class 0 OID 17825)
-- Dependencies: 1501
-- Data for Name: rox_mod_blog_posts; Type: TABLE DATA; Schema: public; Owner: roxyton
--



--
-- TOC entry 1785 (class 2606 OID 17856)
-- Dependencies: 1492 1492
-- Name: rox_acl_access_pkey; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_core_acl_access
    ADD CONSTRAINT rox_acl_access_pkey PRIMARY KEY (rule_id);


--
-- TOC entry 1789 (class 2606 OID 17858)
-- Dependencies: 1493 1493
-- Name: rox_acl_inheritance_pkey; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_core_acl_inheritance
    ADD CONSTRAINT rox_acl_inheritance_pkey PRIMARY KEY (inheritance_id);


--
-- TOC entry 1793 (class 2606 OID 17860)
-- Dependencies: 1494 1494
-- Name: rox_acl_resources_pkey; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_core_acl_resources
    ADD CONSTRAINT rox_acl_resources_pkey PRIMARY KEY (resource_id);


--
-- TOC entry 1791 (class 2606 OID 17862)
-- Dependencies: 1493 1493 1493
-- Name: rox_acl_role_inheritance_unique; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_core_acl_inheritance
    ADD CONSTRAINT rox_acl_role_inheritance_unique UNIQUE (role_id, parent_id);


--
-- TOC entry 1797 (class 2606 OID 17864)
-- Dependencies: 1495 1495
-- Name: rox_acl_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_core_acl_roles
    ADD CONSTRAINT rox_acl_roles_pkey PRIMARY KEY (role_id);


--
-- TOC entry 1787 (class 2606 OID 17866)
-- Dependencies: 1492 1492 1492
-- Name: rox_core_acl_access_resource_name_key; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_core_acl_access
    ADD CONSTRAINT rox_core_acl_access_resource_name_key UNIQUE (resource_name, privilege);


--
-- TOC entry 1795 (class 2606 OID 17868)
-- Dependencies: 1494 1494 1494
-- Name: rox_core_acl_resources_resource_name_key; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_core_acl_resources
    ADD CONSTRAINT rox_core_acl_resources_resource_name_key UNIQUE (resource_name, privilege);


--
-- TOC entry 1799 (class 2606 OID 17870)
-- Dependencies: 1496 1496
-- Name: rox_core_modules_pkey; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_core_modules
    ADD CONSTRAINT rox_core_modules_pkey PRIMARY KEY (directory);


--
-- TOC entry 1801 (class 2606 OID 17872)
-- Dependencies: 1497 1497
-- Name: rox_core_user_profile_pkey; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_core_user_profile
    ADD CONSTRAINT rox_core_user_profile_pkey PRIMARY KEY (uid);


--
-- TOC entry 1805 (class 2606 OID 17874)
-- Dependencies: 1499 1499
-- Name: rox_core_widgets_pkey; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_core_widgets
    ADD CONSTRAINT rox_core_widgets_pkey PRIMARY KEY (widget_id);


--
-- TOC entry 1807 (class 2606 OID 17876)
-- Dependencies: 1500 1500
-- Name: rox_mod_blog_comments_pkey; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_mod_blog_comments
    ADD CONSTRAINT rox_mod_blog_comments_pkey PRIMARY KEY (comment_id);


--
-- TOC entry 1809 (class 2606 OID 17878)
-- Dependencies: 1501 1501
-- Name: rox_mod_blog_posts_pkey; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_mod_blog_posts
    ADD CONSTRAINT rox_mod_blog_posts_pkey PRIMARY KEY (post_id);


--
-- TOC entry 1803 (class 2606 OID 17880)
-- Dependencies: 1498 1498
-- Name: rox_users_pkey; Type: CONSTRAINT; Schema: public; Owner: roxyton; Tablespace: 
--

ALTER TABLE ONLY rox_core_users
    ADD CONSTRAINT rox_users_pkey PRIMARY KEY (uid);


--
-- TOC entry 1810 (class 2606 OID 17881)
-- Dependencies: 1494 1794 1492 1492 1494
-- Name: rox_core_acl_access_resource_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_core_acl_access
    ADD CONSTRAINT rox_core_acl_access_resource_name_fkey FOREIGN KEY (resource_name, privilege) REFERENCES rox_core_acl_resources(resource_name, privilege) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1811 (class 2606 OID 17886)
-- Dependencies: 1796 1492 1495
-- Name: rox_core_acl_access_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_core_acl_access
    ADD CONSTRAINT rox_core_acl_access_role_id_fkey FOREIGN KEY (role_id) REFERENCES rox_core_acl_roles(role_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1812 (class 2606 OID 17891)
-- Dependencies: 1495 1796 1493
-- Name: rox_core_acl_inheritance_parent_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_core_acl_inheritance
    ADD CONSTRAINT rox_core_acl_inheritance_parent_id_fkey FOREIGN KEY (parent_id) REFERENCES rox_core_acl_roles(role_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1813 (class 2606 OID 17896)
-- Dependencies: 1493 1495 1796
-- Name: rox_core_acl_inheritance_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_core_acl_inheritance
    ADD CONSTRAINT rox_core_acl_inheritance_role_id_fkey FOREIGN KEY (role_id) REFERENCES rox_core_acl_roles(role_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1814 (class 2606 OID 17901)
-- Dependencies: 1792 1494 1494
-- Name: rox_core_acl_resources_parent_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_core_acl_resources
    ADD CONSTRAINT rox_core_acl_resources_parent_id_fkey FOREIGN KEY (parent_id) REFERENCES rox_core_acl_resources(resource_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1815 (class 2606 OID 17906)
-- Dependencies: 1494 1792 1496
-- Name: rox_core_modules_resource_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_core_modules
    ADD CONSTRAINT rox_core_modules_resource_id_fkey FOREIGN KEY (resource_id) REFERENCES rox_core_acl_resources(resource_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1816 (class 2606 OID 17911)
-- Dependencies: 1802 1498 1497
-- Name: rox_core_user_profile_uid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_core_user_profile
    ADD CONSTRAINT rox_core_user_profile_uid_fkey FOREIGN KEY (uid) REFERENCES rox_core_users(uid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1817 (class 2606 OID 17916)
-- Dependencies: 1498 1796 1495
-- Name: rox_core_users_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_core_users
    ADD CONSTRAINT rox_core_users_role_id_fkey FOREIGN KEY (role_id) REFERENCES rox_core_acl_roles(role_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1818 (class 2606 OID 17921)
-- Dependencies: 1499 1494 1792
-- Name: rox_core_widgets_resource_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_core_widgets
    ADD CONSTRAINT rox_core_widgets_resource_id_fkey FOREIGN KEY (resource_id) REFERENCES rox_core_acl_resources(resource_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1819 (class 2606 OID 17926)
-- Dependencies: 1500 1501 1808
-- Name: rox_mod_blog_comments_post_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_mod_blog_comments
    ADD CONSTRAINT rox_mod_blog_comments_post_id_fkey FOREIGN KEY (post_id) REFERENCES rox_mod_blog_posts(post_id) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- TOC entry 1820 (class 2606 OID 17931)
-- Dependencies: 1500 1802 1498
-- Name: rox_mod_blog_comments_uid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_mod_blog_comments
    ADD CONSTRAINT rox_mod_blog_comments_uid_fkey FOREIGN KEY (uid) REFERENCES rox_core_users(uid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1821 (class 2606 OID 17936)
-- Dependencies: 1501 1802 1498
-- Name: rox_mod_blog_posts_uid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: roxyton
--

ALTER TABLE ONLY rox_mod_blog_posts
    ADD CONSTRAINT rox_mod_blog_posts_uid_fkey FOREIGN KEY (uid) REFERENCES rox_core_users(uid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1835 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2009-02-23 05:02:45

--
-- PostgreSQL database dump complete
--

