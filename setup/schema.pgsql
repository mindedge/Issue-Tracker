-- $Id: schema.pgsql,v 1.2 2003/10/08 07:08:31 tuxmonkey Exp $

CREATE TABLE configuration (
	variable VARCHAR(32) NOT NULL,
	value TEXT NOT NULL,
	constant CHAR(1) DEFAULT 'f'
);

CREATE TABLE sessions (
  session_id VARCHAR(32) NOT NULL,
  session_data TEXT,
  session_expires INTEGER NOT NULL
);

CREATE TABLE users (
	userid SERIAL, 
	username VARCHAR(32) NOT NULL,
	password VARCHAR(32) NOT NULL,
	first_name VARCHAR(32),
	last_name VARCHAR(32),
	address VARCHAR(64),
	address2 VARCHAR(64),
	telephone VARCHAR(32),
	email VARCHAR(64) NOT NULL,
	sms VARCHAR(64),
	admin CHAR(1) DEFAULT 'f',
	active CHAR(1) DEFAULT 't',
	theme VARCHAR(32),
	PRIMARY KEY(userid)
);

CREATE TABLE groups (
	gid SERIAL, 
	name VARCHAR(255),
	address VARCHAR(100),
	address2 VARCHAR(100),
	contact VARCHAR(64),
	tech VARCHAR(64),
	tao VARCHAR(64),
	brm VARCHAR(64),
	sales VARCHAR(64),
	amount NUMERIC(12,2),
	bought INTEGER,
	used INTEGER,
	start_date VARCHAR(16),
	end_date VARCHAR(16),
  group_type VARCHAR(12),
	active CHAR(1) DEFAULT 't',
	status_reports CHAR(1) DEFAULT 'f',
	notes TEXT,
	email VARCHAR(64),
  prop_user CHAR(1) DEFAULT 'f',
  prop_category CHAR(1) DEFAULT 'f',
  prop_product CHAR(1) DEFAULT 'f',
  prop_status CHAR(1) DEFAULT 'f',
  prop_issue CHAR(1) DEFAULT 'f',
  prop_announce CHAR(1) DEFAULT 'f',
	PRIMARY KEY(gid)
);

CREATE TABLE menus (
	mid SERIAL,
	userid INTEGER NOT NULL,
	text VARCHAR(24) NOT NULL,
	url TEXT NOT NULL,
	PRIMARY KEY(mid)
);

CREATE TABLE permissions (
	permid SERIAL,
	permission VARCHAR(32) NOT NULL,
  group_perm CHAR(1) DEFAULT 'f',
  user_perm CHAR(1) DEFAULT 'f',
  permission_type SMALLINT NOT NULL DEFAULT '1',
  system CHAR(1) DEFAULT 'f',
	PRIMARY KEY(permid)
);

CREATE TABLE permission_sets (
	permsetid SERIAL,
	name VARCHAR(32) NOT NULL,
	description TEXT NOT NULL,
	permissions TEXT NOT NULL,
  system CHAR(1) DEFAULT 'f',
	PRIMARY KEY(permsetid)
);

CREATE TABLE group_permissions (
  permid INTEGER,
  gid INTEGER
);

CREATE TABLE user_permissions (
  permid INTEGER,
  userid INTEGER
);

CREATE TABLE notifications (
	nid SERIAL,
	gid INTEGER NOT NULL,
	userid INTEGER NOT NULL,
	type CHAR(1) DEFAULT 'E',
	PRIMARY KEY(nid)
);

CREATE TABLE group_users (
	gid INTEGER NOT NULL,
	userid INTEGER NOT NULL,
	perm_set INTEGER,
	severity SMALLINT,
	show_group CHAR(1) DEFAULT 't'
);

CREATE TABLE statuses (
	sid SERIAL,
	status VARCHAR(32) NOT NULL,
  status_type SMALLINT,
	PRIMARY KEY(sid)
);

CREATE TABLE categories (
	cid SERIAL, 
	category VARCHAR(64) NOT NULL,
	PRIMARY KEY(cid)
);

CREATE TABLE products (
	pid SERIAL, 
	product VARCHAR(128) NOT NULL,
	PRIMARY KEY(pid)
);

CREATE TABLE issues (
	issueid SERIAL,
	gid INTEGER NOT NULL,
	opened_by INTEGER NOT NULL,
	opened INTEGER NOT NULL,
	closed INTEGER,
	modified INTEGER,
	summary TEXT NOT NULL,
	problem TEXT NOT NULL,
	status SMALLINT NOT NULL,
	category SMALLINT,
	product INTEGER,
	severity SMALLINT NOT NULL,
	private CHAR(1) DEFAULT 'f',
	flags TEXT,
  istatus SMALLINT,
  iseverity SMALLINT,
  due_date INTEGER,
	PRIMARY KEY(issueid)
);

CREATE TABLE events (
	eid SERIAL, 
	issueid INTEGER NOT NULL,
	status SMALLINT,
	userid INTEGER,
	performed_on INTEGER NOT NULL,
	duration NUMERIC(6,2) DEFAULT '0.00',
	fid INTEGER,
	private CHAR(1) DEFAULT 'f',
	action TEXT NOT NULL,
	PRIMARY KEY(eid)
);

CREATE TABLE files (
	fid SERIAL,
	userid INTEGER,
	typeid INTEGER NOT NULL,
	uploaded_on INTEGER,
	name TEXT NOT NULL,
  file_type VARCHAR(16) NOT NULL,
  private CHAR(1) DEFAULT 'f',
	PRIMARY KEY(fid)
);

CREATE TABLE event_modifications (
	eid INTEGER NOT NULL,
	modified INTEGER NOT NULL,
	userid INTEGER NOT NULL,
	changes TEXT NOT NULL
);

CREATE TABLE announcements (
	aid SERIAL,
	title VARCHAR(128) NOT NULL,
	message TEXT NOT NULL,
	posted INTEGER,
	userid INTEGER,
	is_global CHAR(1) DEFAULT 'f',
	PRIMARY KEY(aid)
);

CREATE TABLE announce_permissions (
	aid INTEGER NOT NULL,
	gid INTEGER NOT NULL
);

CREATE TABLE subscriptions (
	sub_id SERIAL,
	userid INTEGER NOT NULL,
	issueid INTEGER NOT NULL,
	PRIMARY KEY(sub_id)
);

CREATE TABLE status_reports (
	userid INTEGER,
	gid INTEGER,
	date_entered INTEGER NOT NULL,
	info TEXT,
	standing SMALLINT
);

CREATE TABLE view_tracking (
  vid SERIAL,
	issueid INTEGER NOT NULL,
	userid INTEGER NOT NULL,
	viewed INTEGER NOT NULL,
  PRIMARY KEY(vid)
);

CREATE TABLE logs (
	lid SERIAL, 
	log_type VARCHAR(32),
	log_message TEXT NOT NULL,
	log_time INTEGER NOT NULL,
	log_user INTEGER NOT NULL,
	PRIMARY KEY(lid)
);

CREATE TABLE issue_groups (
	issueid INTEGER NOT NULL,
	gid INTEGER NOT NULL,
	assigned_to INTEGER,
	opened INTEGER,
	first_response INTEGER DEFAULT '0',
	show_issue character(1) DEFAULT 't',
	deescalated INTEGER
);

CREATE TABLE escalation_points (
	gid INTEGER NOT NULL,
	egid INTEGER NOT NULL
);

CREATE TABLE group_statuses (
	gid INTEGER NOT NULL,
	sid INTEGER NOT NULL
);

CREATE TABLE group_istatuses (
  gid INTEGER NOT NULL,
  sid INTEGER NOT NULL
);

CREATE TABLE group_categories (
	gid INTEGER NOT NULL,
	cid INTEGER NOT NULL
);

CREATE TABLE group_products (
	gid INTEGER NOT NULL,
	pid INTEGER NOT NULL 
);

CREATE TABLE issue_requesters (
	issueid INTEGER NOT NULL,
	requester VARCHAR(64) NOT NULL,
	list VARCHAR(64) NOT NULL,
  PRIMARY KEY(issueid)
);

CREATE TABLE issue_log (
  ilogid SERIAL,
	issueid INTEGER NOT NULL,
	userid INTEGER NOT NULL,
	logged INTEGER NOT NULL,
	message TEXT,
  private CHAR(1) DEFAULT 'f',
  PRIMARY KEY(ilogid)
);

CREATE TABLE user_prefs (
	userid INTEGER NOT NULL,
  preference VARCHAR(255),
  value VARCHAR(255)
);

CREATE TABLE group_prefs (
  gid INTEGER NOT NULL,
  preference VARCHAR(255),
  value VARCHAR(255)
);

CREATE TABLE xmlrpc_connections (
	userid INTEGER NOT NULL,
	token VARCHAR(32) NOT NULL,
	ipaddr VARCHAR(15) NOT NULL,
	UNIQUE(userid)
);

CREATE TABLE sub_groups (
  parent_gid INTEGER NOT NULL,
  child_gid INTEGER NOT NULL,
  prop_user CHAR(1) DEFAULT 'f',
  prop_category CHAR(1) DEFAULT 'f',
  prop_product CHAR(1) DEFAULT 'f',
  prop_status CHAR(1) DEFAULT 'f',
  prop_issue CHAR(1) DEFAULT 'f',
  prop_announce CHAR(1) DEFAULT 'f'
);

CREATE TABLE reports (
  rid SERIAL,
  userid INTEGER NOT NULL,
  name VARCHAR(32) NOT NULL,
  options TEXT NOT NULL,
  PRIMARY KEY(rid)
);
