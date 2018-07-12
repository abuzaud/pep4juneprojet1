INSERT INTO `box` (name, products, current_place, budget, description, reference) VALUES
  ('box1', NULL, '', '50', 'Ground round pig ham hock pork chop tri-tip rump shank boudin burgdoggen short ribs swine landjaeger.', 'REF_BOX_1'),
  ('box2', NULL,'', '120', 'Andouille tri-tip leberkas tail ribeye kielbasa, ham hock burgdoggen. T-bone ball tip strip steak pancetta flank alcatra biltong spare ribs leberkas hamburger brisket.', 'REF_BOX_2'),
  ('box3', NULL,'', '10', 'ork belly salami short ribs tenderloin sausage burgdoggen pork tongue. Bresaola tongue corned beef, cow pastrami tenderloin alcatra picanha. ', 'REF_BOX_3'),
  ('box4', NULL,'', '30', 'Ground round pig ham hock pork chop tri-tip rump shank boudin burgdoggen short ribs swine landjaeger.', ''),
  ('box5', NULL,'', '200', 'ork belly salami short ribs tenderloin sausage burgdoggen pork tongue. Bresaola tongue corned beef, cow pastrami tenderloin alcatra picanha. ', 'REF_BOX_4'),
  ('box6', NULL,'', '75', 'Andouille tri-tip leberkas tail ribeye kielbasa, ham hock burgdoggen. T-bone ball tip strip steak pancetta flank alcatra biltong spare ribs leberkas hamburger brisket.', 'REF_BOX_5'),
  ('box7', NULL,'', '30', 'Meatloaf biltong buffalo spare ribs sirloin, frankfurter beef tongue. Doner cow turducken, salami sirloin flank hamburger corned beef pig drumstick t-bone andouille. Shoulder turducken biltong landjaeger spare ribs tongue.', 'REF_BOX_6'),
  ('box8', NULL,'', '40', 'Meatloaf biltong buffalo spare ribs sirloin, frankfurter beef tongue. Doner cow turducken, salami sirloin flank hamburger corned beef pig drumstick t-bone andouille. Shoulder turducken biltong landjaeger spare ribs tongue.', 'REF_BOX_7'),



INSERT INTO `supplier` (name, source) VALUES
  ('fournisseur_1', '1'),
  ('fournisseur_2', '1'),
  ('fournisseur_3', '1');
  
INSERT INTO `product` (name, supplier, description, reference) VALUES
('product_1', 1, 'Spicy jalapeno bacon ipsum dolor amet pork belly filet mignon pig prosciutto turkey. Hamburger landjaeger pork loin tenderloin, alcatra spare ribs drumstick cupim andouille strip steak. Ground round frankfurter pork tenderloin, beef meatloaf turkey t-bone shankle beef ribs tail chuck biltong spare ribs.', 'X5-41-X94'),
('product_2', 1, ' Venison kevin ribeye, biltong ham leberkas buffalo brisket tri-tip flank beef picanha. Shankle alcatra pancetta filet mignon turducken prosciutto kielbasa swine beef ribs kevin beef hamburger sirloin. Pork porchetta shank hamburger doner spare ribs swine beef ribs prosciutto sausage.', 'XDFDZ5-45D65d-DF'),
('product_3', 2, 'Ham hock tail shank, tongue prosciutto salami ham spare ribs capicola turkey rump kielbasa chuck frankfurter corned beef. T-bone ribeye shank flank short loin biltong salami jerky pancetta ball tip cow.', 'DFSD-D865-D'),
('product_4', 1, 'Meatloaf strip steak fatback hamburger frankfurter kevin. Ground round hamburger ball tip burgdoggen tongue. Kielbasa turkey ham cupim tri-tip andouille ham hock ground round pastrami ribeye. ', 'DEDF4868451'),
('product_5', 2, 'Biltong pancetta venison turkey drumstick meatloaf burgdoggen shoulder kielbasa buffalo pork chop short loin flank pork loin. Kevin shoulder cow salami pastrami drumstick pork belly. Short loin ground round spare ribs ham hock, shoulder leberkas brisket swine salami. ', 'SDFE57846923');

INSERT INTO `role` (name, fullname) VALUES
('ROLE_ADMIN', 'Administrateur'),
('ROLE_USER', 'Utilisateur'),
('ROLE_PM', 'Responsable des achats'),
('ROLE_MO', 'Marketing Officer'),
('ROLE_MM', 'Marketing Manager'),
('ROLE_DIRECTOR', 'Directeur'),
('ROLE_SUPPLIER', 'Supplier');