INSERT INTO `category` (category_id, parent_id, category_name, category_description, category_is_deleted)
VALUES (1, 0, 'Professional Education', 'Courses and training for professionals', 0),
       (2, 0, 'Patient Education', 'Health education materials for patients', 0),
       (3, 0, 'Research', 'Latest findings and research publications', 0),
       (4, 0, 'Products', 'Catalog of our healthcare products', 0),
       (5, 0, 'Clinic', 'Information about our clinic services', 0),
       (6, 1, 'Student Resources', 'Educational resources for students', 0),
       (7, 1, 'Faculty Resources', 'Teaching aids and materials for faculty', 0),
       (8, 3, 'Latest Research', 'Recent research projects and results', 0),
       (9, 3, 'Media Library', 'Videos and images from our media archive', 0),
       (10, 4, 'Teeth Whitening', 'The product that helps whiten teeth', 0),
       (11, 4, 'ToothPaste', 'The product for dental care', 0),
       (12, 4, 'TootBrushes', 'The product for dental care', 0),
       (13, 4, 'MouthWash', 'Oral hygiene products', 0);


INSERT INTO `user` (`username`, `password_hash`, `email`, `status`, `is_deleted`, `phone`, `role`)
VALUES ('khanh', SHA2('admin123', 256), 'NamKhanh@gmail.com', 1, 0, '012345678', 'admin'),
       ('hung', SHA2('admin123', 256), 'QuangHung@gmail.com', 1, 0, '012345678', 'admin'),
       ('dat', SHA2('admin123', 256), 'Dat@gmail.com', 1, 0, '012345678', 'admin'),
       ('alex', SHA2('password123', 256), 'AlexEmail@gmail.com', 1, 0, '987654321', 'manager'),
       ('jordan', SHA2('password234', 256), 'JordanEmail@gmail.com', 1, 0, '987650123', 'manager'),
       ('casey', SHA2('password345', 256), 'CaseyEmail@gmail.com', 1, 0, '987654321', 'manager'),
       ('morgan', SHA2('password456', 256), 'MorganEmail@gmail.com', 1, 0, '987650123', 'manager');

INSERT INTO `clinic` (`clinic_id`, `clinic_name`, `clinic_address`, `clinic_phone_number`, `clinic_description`,
                      `clinic_is_deleted`)
VALUES (1, 'Family Dentist', '2 John St, New York, NY 10038, US', '8663151268',
        'Established in 2013, Family Dentist New York has served', 0),
       (2, 'Dental Arts', '55 E 9th St, New York, NY 10003, US', '8663151268',
        'Advanced Dental Arts provides a wide variety of dental ', 0),
       (3, 'Dental Office', '245 E 63rd St 110, New York, NY 10065, US', '8663151268',
        'Advanced Dental Arts provides a wide variety of dental', 0),
       (4, 'General Dentistry', '133 E 58th St Ste 409, New York, NY 10022, US', '8663151268',
        'Friday by appointment Looking to find a dentist', 0),
       (5, 'Midtown Dental', '12 E 41st St suite 1100, New York, NY 10017, US', '8663151268',
        'Midtown Dental Care Associates provides full-service', 0),
       (6, 'Sacha Dental', '20 E 46th St Rm 1301, New York, NY 10017, US', '8663151268',
        'Midtown Dental Care Associates provides full-service', 0),
       (7, 'Expert Dental', '110 E 40th St 104, New York, NY 10016, US', '8663151268',
        'Expert Dental offers a full range of general & cosmetic', 0),
       (8, 'Diamond District', '10 W 46th St #1401, New York, NY 10036, US', '8663151268',
        'Your premier destination for exceptional dental care', 0);

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_description`, `product_price`,
                        `product_is_deleted`)
VALUES (1, 10, 'Alienate Dental',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        10, 0),
       (2, 10, 'Dental Anesthesia',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        20, 0),
       (3, 10, 'Dental Articulating',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        18, 0),
       (4, 10, 'Dental Chair',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        700, 0),
       (5, 11, 'Dental Diamond Disc',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        30, 0),
       (6, 11, 'Dental Electroplate',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        46, 0),
       (7, 11, 'Dental Matrix Band',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        32, 0),
       (8, 11, 'Dental Sander Gun',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        56, 0),
       (9, 12, 'Dental Matrix Band',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        89, 0),
       (10, 12, 'Dental Tungsten',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        53, 0),
       (11, 12, 'Polishing System',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        23, 0),
       (12, 12, 'Instrument Kit',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        71, 0),
       (13, 13, 'Latex Gloves',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        123, 0),
       (14, 13, 'Orthodontic Care',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        220, 0),
       (15, 13, 'Orthodontic Forceps',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        12, 0),
       (16, 13, 'Impression Material',
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
        91, 0);

INSERT INTO posts (post_id, category_id, post_title, post_content, post_is_deleted)
VALUES (1, 8, 'The Future of Implant Dentistry', 'As clinicians, we are replacing teeth that have evolved and changed throughout thousands of years. Maxillary molars, for example, have 3 roots instead of 2, because the bone is softer and the forces are greater in the posterior of the mouth.
        It has already been one year since the Implants Today section was first published. I want to thank Dentistry Today’s editor-in-chief, Dr. Damon Adams, for the invitation to be the editor of the implant section and for fostering a shared vision between us for this exciting new content. The support and encouragement of the entire editorial team and the positive feedback from our readers are also very much appreciated. I would also like to acknowledge and thank all the members of our world-class Implant Advisory Board who, during the past year, have contributed excellent and clinically relevant articles aimed at the GP reader. It takes dedication and a lot of time to write a quality clinical article and, through those efforts, Dentistry Today has been able to offer an abundance of solid information this past year that should have the potential to make a positive impact on your practices and patients. Damon and I would also like to encourage our clinician readers to submit implant articles to Dentistry Today for editorial review and, if accepted, publication. When our readers and colleagues contribute interesting clinical case report articles, a culture of shared knowledge is created. It is this concept of shared knowledge upon which our editorial content in Dentistry Today was founded.
        The “Future of Implant Dentistry” was the inaugural topic last September. This, along with the other 11 topics that were covered throughout the year, will be revisited each year. By revisiting the specified topics that cover the many aspects of implant dentistry, a fresh annual retrospective can be realized. Implant dentistry is an evolving discipline and, through re-examining, these same well-rounded topics and fresh perspectives can be presented. With our potentially content-rich topics, such as guided implant surgery, implants in the aesthetic zone, implant overdentures, cone beam CT (CBCT) for implant dentistry, and 8 other exciting implant-related topics, new information will be updated and discussed each year.
        The future of implant dentistry continues to be exciting, evolving, and more predictable. The dental implant industry a billion-dollar enterprise that is supported by improved materials, technologies, and various clinical procedures every year. I would like to look at the future of dental implant treatment with the grounding perspective of first looking at the past. As clinicians, we are replacing teeth that have evolved and changed throughout thousands of years. Maxillary molars, for example, have 3 roots instead of 2, because the bone is softer and the forces are greater in the posterior of the mouth. Cuspids have longer roots to support the forces of occlusion in extrusive movements. Through this historical and evolutionary perspective, one can appreciate any future progress with dental implants with respect of the daunting task and responsibility at hand. Dr. Carl Misch has been speaking on this perspective for many years. The future of successfully replacing what nature has created—and then sometimes fails—with implants requires the latest technologies, techniques, materials, and continuing education (CE).
        FUTURE TECHNOLOGIES
        As computer technology advances, there is a direct impact on implant dentistry and the potential for increased success. There are a growing number of companies that offer CBCT machines and software planning programs. Better resolution, faster scans, and the availability of virtual planning are examples in the arena of technology improvement. More sophisticated Internet technology at higher speeds has allowed clinicians and laboratory teams to share treatment planning information and to foster better collaboration among clinicians as well as those professionals representing different specialties who work together on the patient’s behalf. CBCT scanning and associated CAD/CAM technologies can now be used to plan and mill an entire case, with digital files following the surgical positions all the way to the provisional and final prosthesis. This is true for both quadrant implant dentistry and full-arch replacement teeth. The technological advances to measure the initial and post-integrated stability of dental implants have also impacted the success of treatment. The Implant Stability Quota (ISQ) measures the true bone-to-implant contact, as opposed to the perceived torque value. Through having an ISQ reference number, clinical loading decisions can be made with an objective value behind them. This information is especially useful for decisions related to immediately loaded implants.
        Intraoral scanning technologies have evolved to a level that can totally replace manual tray impressions with dental implants. A digital scan of an implant requires an appropriate impression coping that correlates to the appropriate implant system library. Currently available scan copings are affiliated with closed systems specific to an implant company. In the future, open digital impression systems will allow for more dentists to utilize this technology. Once a digital intraoral impression is made, that information can be used to design a custom abutment, the provisional, and final crowns. Through digital intraoral scanning, the entire workflow can be digital with great accuracy. Models that are either CAD/CAM milled or 3-D printed can be used. The availability of chairside box scanners allow a clinician to scan a prosthetically approved full-arch bridge provisional so that a zirconia duplicate can be milled as the permanent restoration. Box scanners have substantially reduced in price and size of the units, making them easier for clinicians to obtain.
        FUTURE TECHNIQUES
        Surgical and prosthetic techniques for implant dentistry are closely related to technological advances as well as materials and CE. When a clinician adapts a new technique for implant treatment, it is often tied into advancements in other areas of implant dentistry. Immediate loading of dental implants is an example. Through advancements in implant design, and the availability of measuring implant stability with an ISQ reading, immediately loaded implants have become more predictable. As immediate loading becomes more mainstream, there will be more case studies upon which to grow our knowledge base, then to share that information through educational venues.
        Another example of a technique that is based on technology is the increased use of growth factors in everyday implant treatment. Years ago, it was expensive and cumbersome to obtain platelet growth factors. Now, via technological advances and the ability to share information, platelet-based growth factors, such as platelet-rich plasma and fibrin, can be obtained and processed in a simple and inexpensive manner. Many other techniques are trending with the advancement of implant dentistry: conservative sinus grafting techniques, extraction techniques, soft-tissue grafting, and hard-tissue grafting are all areas that have evolved and will continue to do so, from technology, materials, and advancements in education.
        FUTURE MATERIALS
        Implant dentistry is a material-oriented discipline. From the implant itself to prosthetic parts, materials impact the success rates of implant treatment. In the past few years, there has been a trend toward innovative implant designs to help stabilize hard and soft tissue around implants. There are more choices from implant manufacturers as far as different heights and widths of implants. Manufacturers have offered an increase in shorter implant options in the past year, due to material designs and time-tested proof of success in the industry. Materials are also partially dictated by demand, with manufacturers listening to trends in the industry.
        Zirconia continues to increase in the implant industry as a material for both implant design and prosthetic options. There are now 2-piece zirconia implants available allowing for 2-stage options and increased clinical applications. Major implant companies are also starting to create zirconia implant options, showing a trend and a real presence of increased use of zirconia in the implant world. CAD/CAM technology, which has led to the creation and use of zirconia implant bridges and crowns, continues to grow. In addition, there is a trend toward increased acceptance of zirconia, as this material shows continued success as a prosthetic option. There is also an increase in the use of 3-D printing for provisionals and models, as this technology has demonstrated increased accuracy during the past few years, while becoming more affordable. This also ties into the trend of a total digital workflow. There is even a milled-then-sintered metal option that is awaiting US Food and Drug Administration approval and should be available soon. This would further simplify designing and creating metal bars for smaller laboratories.
        FUTURE EDUCATION
        The collaboration of clinical experience based on technology, materials, and techniques is really what the future of implant dentistry is grounded upon. The sharing of information in journals, courses, and online is where true growth in this industry occurs. With digital technologies advancing, this will become even more prevalent and will assist the growth and success of implant dentistry as time goes on. Webinars, online planning sessions, and live online telecasts are just a few venues available for implant education. The many online education groups such as Dental XP and VuMedi offer thousands of hours of CE that were not available just a few years ago. Technology has also increased the quality of these presentations, allowing for an even higher level of quality education. Online planning and case sharing are also becoming mainstream, even furthering treatment planning collaborative efforts. All of this exchanging of information will propagate growth in the implant field, and I believe this will exponentially increase as time goes on.
        This month, Implants Today Advisory Board member Dr. Natalie Wong’s article exemplifies the future of implant dentistry and how the collaboration of technology, materials, and techniques can create excellence in dental implant treatment. The guided case presented truly shows how advanced the industry has become, where a digital plan is physically implemented based on milled guides and a pre-created provisional restoration is delivered at the time of surgery.
        It is from the publication of excellent cases like these that clinicians from all over the world can share and learn about the latest technology, techniques, and materials to further advance the future of implant dentistry. Here at Dentistry Today, we envision this collaboration of science and technology only increasing and leading to even more predictable implant treatment for the future.',
        0),
       (2, 8, 'Understanding Periodontal Disease: Symptoms, Causes, and Treatment Options', 'Periodontal disease, commonly known as gum disease, poses a significant threat to both your teeth and the underlying bone structure. This condition can lead to serious consequences if left untreated, affecting the overall health of your mouth.
        This blog aims to shed light on the intricacies of periodontal disease, its implications, and how it can impact your oral well-being.By recognizing warning signs and seeking timely treatment, you can safeguard your smile and potentially avoid more complex issues down the road.
        At Atlanta Center for Advanced Periodontics, we take pride in being your trusted destination for cutting-edge periodontal care and dental implant surgery. Let’s embark on this enlightening journey together with the shared vision of nurturing your periodontal health to its fullest potential.
        What is Periodontal Disease?
        Periodontal disease, commonly known as gum disease, is a multifaceted oral condition with distinct stages. Early onset, known as gingivitis, begins with plaque accumulation on the teeth and gum line, leading to gum inflammation and bleeding. If left untreated, it progresses into a more severe stage called periodontitis, where the infection worsens, affecting the bone and connective tissues that support the teeth.
        Addressing gingivitis promptly is crucial to prevent its advancement. Unfortunately, misconceptions about gum disease can hinder timely intervention. Raising awareness of its prevalence and dispelling myths surrounding oral health are vital steps in promoting early detection and effective management of periodontal disease.',
        0),
       (3, 9, 'Implant Dentistry', 'Video', 0),
       (4, 9, 'Periodontal Disease', 'Video', 0),
# Khanh
       (5, 6, 'Patient-Bacteria Study',
        'Patient education is a critical aspect of healthcare, aimed at empowering individuals with the knowledge, skills, and confidence to manage their health and make informed decisions about their care. It involves healthcare professionals providing patients with relevant information about their conditions, treatment options, the management of symptoms, and the prevention of complications. Effective patient education can improve health outcomes, enhance the quality of care, reduce healthcare costs, and increase patient satisfaction. By fostering a collaborative relationship between patients and healthcare providers, patient education helps individuals take an active role in their healthcare journey, leading to better health behaviors and outcomes.',
        0),
       (6, 6, 'Professional-Bacteria Study',
        'Patient education is a critical aspect of healthcare, aimed at empowering individuals with the knowledge, skills, and confidence to manage their health and make informed decisions about their care. It involves healthcare professionals providing patients with relevant information about their conditions, treatment options, the management of symptoms, and the prevention of complications. Effective patient education can improve health outcomes, enhance the quality of care, reduce healthcare costs, and increase patient satisfaction. By fostering a collaborative relationship between patients and healthcare providers, patient education helps individuals take an active role in their healthcare journey, leading to better health behaviors and outcomes.',
        0),
       (7, 2, 'Patient-Bacteria Studying',
        'Patient education is a critical aspect of healthcare, aimed at empowering individuals with the knowledge, skills, and confidence to manage their health and make informed decisions about their care. It involves healthcare professionals providing patients with relevant information about their conditions, treatment options, the management of symptoms, and the prevention of complications. Effective patient education can improve health outcomes, enhance the quality of care, reduce healthcare costs, and increase patient satisfaction. By fostering a collaborative relationship between patients and healthcare providers, patient education helps individuals take an active role in their healthcare journey, leading to better health behaviors and outcomes.',
        0),
       (8, 2, 'Professional-Bacteria Study',
        'Patient education is a critical aspect of healthcare, aimed at empowering individuals with the knowledge, skills, and confidence to manage their health and make informed decisions about their care. It involves healthcare professionals providing patients with relevant information about their conditions, treatment options, the management of symptoms, and the prevention of complications. Effective patient education can improve health outcomes, enhance the quality of care, reduce healthcare costs, and increase patient satisfaction. By fostering a collaborative relationship between patients and healthcare providers, patient education helps individuals take an active role in their healthcare journey, leading to better health behaviors and outcomes.',
        0),
       (9, 7, 'Professional-Bacteria Study',
        'Professional education refers to the specialized training and continuous development programs designed for individuals in various fields to enhance their skills, knowledge, and competencies required for their professions. This form of education encompasses a broad range of activities, including advanced degrees, certifications, workshops, and seminars, aimed at keeping professionals up-to-date with the latest developments, technologies, and best practices in their respective areas of expertise. Professional education not only facilitates career advancement and improves job performance but also ensures that professionals can provide the highest quality of service, adhere to industry standards, and meet the evolving needs of society and the marketplace. Through lifelong learning, professionals maintain their relevance, contribute to their fields, and support the ongoing improvement of professional standards and practices.',
        0),
       (10, 7, 'Professional-Bacteria Study 2',
        'Professional education refers to the specialized training and continuous development programs designed for individuals in various fields to enhance their skills, knowledge, and competencies required for their professions. This form of education encompasses a broad range of activities, including advanced degrees, certifications, workshops, and seminars, aimed at keeping professionals up-to-date with the latest developments, technologies, and best practices in their respective areas of expertise. Professional education not only facilitates career advancement and improves job performance but also ensures that professionals can provide the highest quality of service, adhere to industry standards, and meet the evolving needs of society and the marketplace. Through lifelong learning, professionals maintain their relevance, contribute to their fields, and support the ongoing improvement of professional standards and practices.',
        0),
#       HUNG
       (11, 8, 'Dental Health & Hygiene for Young Children', 'As you might guess, the number-one dental problem among preschoolers is tooth decay.
        •	One out of 10 two- year-olds already have one or more cavities
        •	By age three, 28% of children have one or more cavities
        •	By age five, nearly 50% of children have one or more cavities
        Many parents assume that cavities in baby teeth don''t matter, because they''ll be lost anyway. But that''s not true. Dental decay in baby teeth can negatively affect permanent teeth and lead to future dental problems.
        Teaching Good Dental Habits
        The best way to protect your child''s teeth is to teach him good dental habits. With the proper coaching he''ll quickly adopt good oral hygiene as a part of his daily routine. However, while he may be an enthusiastic participant, he won''t yet have the control or concentration to brush his teeth all by himself. You''ll need to supervise and help him so that the brush removes all the plaque—the soft, sticky, bacteria- containing deposits that accumulate on the teeth, causing tooth decay. Also, keep an eye out for areas of brown or white spots which might be signs of early decay.',
        0),
        (12, 9, 'Brewer Dental, Orthodontic and Pediatric centre', 'video',
        0);

INSERT INTO `media` (`media_id`, `media_type`, `media_path`, `media_text`, `media_is_deleted`)
VALUES (1, 'image', '../../img/clinic1.jpg', 'image', 0),
       (2, 'image', '../../img/clinic2.jpg', 'image', 0),
       (3, 'image', '../../img/clinic3.jpg', 'image', 0),
       (4, 'image', '../../img/clinic4.jpg', 'image', 0),
       (5, 'image', '../../img/clinic5.jpg', 'image', 0),
       (6, 'image', '../../img/clinic6.jpg', 'image', 0),
       (7, 'image', '../../img/clinic7.jpg', 'image', 0),
       (8, 'image', '../../img/clinic8.jpg', 'image', 0),
       (9, 'image', '../../img/product1.jpg', 'image', 0),
       (10, 'image', '../../img/product2.jpg', 'image', 0),
       (11, 'image', '../../img/product3.jpg', 'image', 0),
       (12, 'image', '../../img/product4.jpg', 'image', 0),
       (13, 'image', '../../img/product5.jpg', 'image', 0),
       (14, 'image', '../../img/product6.jpg', 'image', 0),
       (15, 'image', '../../img/product7.jpg', 'image', 0),
       (16, 'image', '../../img/product8.jpg', 'image', 0),
       (17, 'image', '../../img/product9.jpg', 'image', 0),
       (18, 'image', '../../img/product10.jpg', 'image', 0),
       (19, 'image', '../../img/product11.jpg', 'image', 0),
       (20, 'image', '../../img/product12.jpg', 'image', 0),
       (21, 'image', '../../img/product13.jpg', 'image', 0),
       (22, 'image', '../../img/product14.jpg', 'image', 0),
       (23, 'image', '../../img/product15.jpg', 'image', 0),
       (24, 'image', '../../img/product16.jpg', 'image', 0),
       (25, 'image', '../../img/research1.jpg', 'image title', 0),
       (26, 'image', '../../img/research2.jpg', 'image title', 0),
       (27, 'video', '../../vid/research3.mp4', 'video title', 0),
       (28, 'video', '../../vid/research4.mp4', 'video title', 0),
       (29, 'image/jpeg', '../../img/professional1.jpg', 'study', 0),
       (30, 'image/jpeg', '../../img/professional2.jpg', 'study', 0),
       (31, 'image/jpeg', '../../img/patient1.jpg', 'study', 0),
       (32, 'image/jpeg', '../../img/patient2.jpg', 'study', 0),
       (33, 'image/jpeg', '../../img/professional3.jpg', 'study', 0),
       (34, 'image/jpeg', '../../img/professional4.jpg', 'study', 0),
       (35, 'image', '../../img/research5.jpg', 'image title', 0),
       (36, 'video', '../../vid/research6.mp4', 'video title', 0);

INSERT INTO `itemmedia` (`id`, `item_id`, `media_id`, `item_type`, `item_is_deleted`)
VALUES (1, 1, 1, 'clinic', 0),
       (2, 2, 2, 'clinic', 0),
       (3, 3, 3, 'clinic', 0),
       (4, 4, 4, 'clinic', 0),
       (5, 5, 5, 'clinic', 0),
       (6, 6, 6, 'clinic', 0),
       (7, 7, 7, 'clinic', 0),
       (8, 8, 8, 'clinic', 0),
       (9, 1, 9, 'product', 0),
       (10, 2, 10, 'product', 0),
       (11, 3, 11, 'product', 0),
       (12, 4, 12, 'product', 0),
       (13, 5, 13, 'product', 0),
       (14, 6, 14, 'product', 0),
       (15, 7, 15, 'product', 0),
       (16, 8, 16, 'product', 0),
       (17, 9, 17, 'product', 0),
       (18, 10, 18, 'product', 0),
       (19, 11, 19, 'product', 0),
       (20, 12, 20, 'product', 0),
       (21, 13, 21, 'product', 0),
       (22, 14, 22, 'product', 0),
       (23, 15, 23, 'product', 0),
       (24, 16, 24, 'product', 0),
       (25, 1, 25, 'research', 0),
       (26, 2, 26, 'research', 0),
       (27, 3, 27, 'research', 0),
       (28, 4, 28, 'research', 0),
       (29, 5, 29, 'posts', 0),
       (30, 6, 30, 'posts', 0),
       (31, 7, 31, 'posts', 0),
       (32, 8, 32, 'posts', 0),
       (33, 9, 33, 'posts', 0),
       (34, 10, 34, 'posts', 0),
       (35, 11, 35, 'research', 0),
       (36, 12, 36, 'research', 0);