#!/usr/bin/env bash
export $(cat .env | xargs)

echo "Installing 00000000000000_create_security_tables..."
mysql -u $DB_USER -p $DB_NAME < app/migrations/00000000000000_create_security_tables.sql

echo "Installing 11111111111111_insert_admin_user..."
mysql -u $DB_USER -p $DB_NAME < app/migrations/11111111111111_insert_admin_user.sql
