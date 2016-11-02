INSERT INTO `users` VALUES (
  DEFAULT, # id
  'Administrator', # name
  'admin@silex-skeleton.app', # email
  '$2y$13$dymYzWmfR02NB0II8HnYR.Rh4y.sz9tXci5hi2meik/X1xgDRGAx2', # password
  'ROLE_ADMIN', # roles
  'PkgeJgQOPbLbhKeO', # salt
  1, # is_confirmed
  1, # is_enabled
  0, # is_locked
  CURRENT_TIMESTAMP, # created_at
  NULL # updated_at
);
