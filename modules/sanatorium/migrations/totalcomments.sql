INSERT INTO fv_sanatorium_total_comments(sanatorium_id)
  SELECT sanatorium.id
  FROM fv_sanatorium_sanatoriums sanatorium
  WHERE NOT EXISTS (SELECT sanatorium_id FROM fv_sanatorium_total_comments comment
  WHERE comment.sanatorium_id = sanatorium.id);