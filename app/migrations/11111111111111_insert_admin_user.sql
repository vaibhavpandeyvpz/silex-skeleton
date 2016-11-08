INSERT INTO `users` VALUES (
  DEFAULT, # id
  'Administrator', # name
  'admin@silex-skeleton.app', # email
  '$2y$13$dymYzWmfR02NB0II8HnYR.Rh4y.sz9tXci5hi2meik/X1xgDRGAx2', # password
  'ROLE_ADMIN', # roles
  'PkgeJgQOPbLbhKeO', # salt
  TRUE, # is_enabled
  DEFAULT, # is_locked
  CURRENT_TIMESTAMP, # created_at
  DEFAULT # updated_at
);
