-- =============================================================================
-- mysql/init/01-init.sql — Database Initialization
-- =============================================================================

-- Ensure UTF8MB4 for WordPress
ALTER DATABASE `wordpress_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- WordPress user: least-privilege
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER,
      CREATE TEMPORARY TABLES, LOCK TABLES, EXECUTE, CREATE VIEW, SHOW VIEW
  ON `wordpress_db`.*
  TO 'wordpress_user'@'%';

-- Monitoring user (read-only)
CREATE USER IF NOT EXISTS 'exporter'@'%' IDENTIFIED BY 'TechPro@Exporter#2024';
GRANT PROCESS, REPLICATION CLIENT, SELECT ON *.* TO 'exporter'@'%';
GRANT SELECT ON performance_schema.* TO 'exporter'@'%';

FLUSH PRIVILEGES;
