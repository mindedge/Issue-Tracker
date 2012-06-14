-- $Id: indexes.sql,v 1.2 2003/10/08 07:08:31 tuxmonkey Exp $

-- Create Indexes
CREATE INDEX idx_events_issueid ON events (issueid);
CREATE INDEX idx_view_track_userid_issueid ON view_tracking (userid,issueid);
CREATE INDEX idx_user_prefs_userid ON user_prefs (userid);
CREATE INDEX idx_status_reports_gid ON status_reports (gid);
CREATE INDEX idx_issue_groups_issueid ON issue_groups (issueid);
CREATE INDEX idx_issue_groups_gid ON issue_groups (gid);
CREATE INDEX idx_issue_groups_issueid_gid ON issue_groups (issueid,gid);
CREATE INDEX idx_issue_requesters_issueid ON issue_requesters (issueid);
CREATE INDEX idx_escalation_points_gid ON escalation_points (gid);
CREATE INDEX idx_escalation_points_egid ON escalation_points (egid);
CREATE INDEX idx_group_statuses_gid ON group_statuses (gid);
CREATE INDEX idx_group_categories_gid ON group_categories (gid);
CREATE INDEX idx_group_products_gid ON group_products (gid);
CREATE INDEX idx_issue_log_issueid ON issue_log (issueid);
CREATE INDEX idx_group_users_gid ON group_users (gid);
CREATE INDEX idx_group_users_userid ON group_users (userid);
CREATE INDEX idx_group_users_gid_userid ON group_users (gid,userid);
CREATE INDEX idx_issues_status ON issues (status);
CREATE INDEX idx_events_fid ON events (fid);
CREATE INDEX idx_sub_groups_child ON sub_groups (child_gid);
CREATE INDEX idx_sub_groups_parent ON sub_groups (parent_gid);
