-- $Id: data.sql,v 1.7 2003/10/08 07:08:31 tuxmonkey Exp $

-- Default Statuses
INSERT INTO statuses (status,status_type) VALUES('Registered',1);
INSERT INTO statuses (status,status_type) VALUES('Waiting on Tech',2);
INSERT INTO statuses (status,status_type) VALUES('Waiting on Client',2);
INSERT INTO statuses (status,status_type) VALUES('Closed by Tech',5);
INSERT INTO statuses (status,status_type) VALUES('Closed by Client',5);
INSERT INTO statuses (status,status_type) VALUES('Long Term',3);
INSERT INTO statuses (status,status_type) VALUES('Stale',4);
INSERT INTO statuses (status,status_type) VALUES('Auto Closed',6);

-- Default Categories
INSERT INTO categories (category) VALUES('Demo Category');

-- Default Products
INSERT INTO products (product) VALUES('Demo Product');

-- Default Groups (Do not remove the Parser Rejects group)
INSERT INTO groups (name,notes) VALUES('Employees','This group is the members that maintain the issue tracker system.');
INSERT INTO groups (name,notes) VALUES('Demo Group','Just a demo group');
INSERT INTO groups (name,notes) VALUES('Parser Rejects','This group is used to track emails that the parser rejects. (DO NOT DELETE)');

-- Default Group Categories
INSERT INTO group_categories (gid,cid) VALUES(1,1);
INSERT INTO group_categories (gid,cid) VALUES(2,1);
INSERT INTO group_categories (gid,cid) VALUES(3,1);

-- Default Group Products
INSERT INTO group_products (gid,pid) VALUES(1,1);
INSERT INTO group_products (gid,pid) VALUES(2,1);
INSERT INTO group_products (gid,pid) VALUES(3,1);

-- Default Group Statuses
INSERT INTO group_statuses (gid,sid) VALUES(1,1);
INSERT INTO group_statuses (gid,sid) VALUES(1,2);
INSERT INTO group_statuses (gid,sid) VALUES(1,3);
INSERT INTO group_statuses (gid,sid) VALUES(1,4);
INSERT INTO group_statuses (gid,sid) VALUES(1,5);
INSERT INTO group_statuses (gid,sid) VALUES(1,6);
INSERT INTO group_statuses (gid,sid) VALUES(2,1);
INSERT INTO group_statuses (gid,sid) VALUES(2,2);
INSERT INTO group_statuses (gid,sid) VALUES(2,3);
INSERT INTO group_statuses (gid,sid) VALUES(2,4);
INSERT INTO group_statuses (gid,sid) VALUES(2,5);
INSERT INTO group_statuses (gid,sid) VALUES(2,6);
INSERT INTO group_statuses (gid,sid) VALUES(3,1);
INSERT INTO group_statuses (gid,sid) VALUES(3,2);
INSERT INTO group_statuses (gid,sid) VALUES(3,3);
INSERT INTO group_statuses (gid,sid) VALUES(3,4);
INSERT INTO group_statuses (gid,sid) VALUES(3,5);
INSERT INTO group_statuses (gid,sid) VALUES(3,6);

-- Default Users (Do not remove the client user)
INSERT INTO users (username,password,email,admin) VALUES('admin','fe01ce2a7fbac8fafaed7c982a04e229','admin@localhost','t');
INSERT INTO users (username,password,email) VALUES('demo','fe01ce2a7fbac8fafaed7c982a04e229','demo@localhost');
INSERT INTO users (username,password,email,first_name,last_name,active) VALUES('client','c51019991f3032e2d102fbbfa2bc3a53','emailparser','Email','Parser','f');

-- Deafult Group users
INSERT INTO group_users (userid,gid,perm_set) VALUES(1,1,1);
INSERT INTO group_users (userid,gid,perm_set) VALUES(2,1,2);
INSERT INTO group_users (userid,gid,perm_set) VALUES(1,2,1);
INSERT INTO group_users (userid,gid,perm_set) VALUES(2,2,2);

-- Default Permissions
INSERT INTO permissions (permission,system) VALUES('create_issues','t');
INSERT INTO permissions (permission,system) VALUES('create_announcements','t');
INSERT INTO permissions (permission,system) VALUES('view_private','t');
INSERT INTO permissions (permission,system) VALUES('upload_files','t');
INSERT INTO permissions (permission,system) VALUES('update_group','t');
INSERT INTO permissions (permission,system) VALUES('technician','t');
INSERT INTO permissions (permission,system) VALUES('move_issues','t');
INSERT INTO permissions (permission,system) VALUES('edit_events','t');
INSERT INTO permissions (permission,user_perm,system) VALUES('product_manager','t','t');
INSERT INTO permissions (permission,user_perm,system) VALUES('status_manager','t','t');
INSERT INTO permissions (permission,user_perm,system) VALUES('category_manager','t','t');

-- Default Permission Sets
INSERT INTO permission_sets (name,description,permissions,system) VALUES ('Group Administrator','This permission set is for group administrators. It gives the user all available privileges for the group.','create_issues,create_announcements,view_private,upload_files,update_group,technician,move_issues,edit_events','t');
INSERT INTO permission_sets (name,description,permissions,system) VALUES ('Client','This is the default client privilege set. It includes just enough permissions for a client to create issues and what would be required to update those issues with useful information.','create_issues,upload_files','t');
INSERT INTO permission_sets (name,description,permissions,system) VALUES ('Privileged Client','This permission set is the same as the standard client permission set, with the addition of the permission to create announcements.','create_issues,create_announcements,upload_files','t');
INSERT INTO permission_sets (name,description,permissions,system) VALUES ('Super Client','This permission set is the same as as the privileged client permission set, with the addition of the permission to view private events.','create_issues,create_announcements,view_private,upload_files','t');
INSERT INTO permission_sets (name,description,permissions,system) VALUES ('Technician','This is the standard group technician permission set.','create_issues,create_announcements,view_private,upload_files,technician','t');
