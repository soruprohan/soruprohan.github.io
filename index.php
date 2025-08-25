<?php
require_once __DIR__ . '/admin/config.php';

// Education
$education_rows = [];
if ($res = $mysqli->query("SELECT * FROM education ORDER BY order_index ASC, start_year DESC, id DESC")) {
    $education_rows = $res->fetch_all(MYSQLI_ASSOC);
}

// Projects (only published)
$project_rows = [];
if ($res = $mysqli->query("SELECT * FROM projects WHERE published=1 ORDER BY order_index ASC, id DESC")) {
    $project_rows = $res->fetch_all(MYSQLI_ASSOC);
}

// Testimonials
$testimonial_rows = [];
if ($res = $mysqli->query("SELECT * FROM testimonials ORDER BY order_index ASC, id DESC")) {
    $testimonial_rows = $res->fetch_all(MYSQLI_ASSOC);
}

?>
<!------------------------------------------------------------->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Md. Sorup Rohan</title>

    <!--swiper css-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!--box icons-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--custom css-->
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <!-- header design -->
    <header class="header">

        <div class="header-spacer"></div> <!--used only to push header elements to the right, no other functionality-->

        <nav class="navbar">
            <a href="#home" class="active">Home</a>
            <a href="#about">About</a>
            <a href="#education">Education</a>
            <a href="#experience">Experience</a>
            <a href="#portfolio">Portfolio</a>
            <a href="#skills-section">Skills</a>
            <a href="#contact">Contact</a>
        </nav>

        <div class="bx bx-moon" id="darkMode-icon"></div>

        <div class="bx bx-menu" id="menu-icon"></div>
    </header>

    <!--home section design-->
    <section class="home" id="home">
        <div class="home-content">
            <h3>Hello, I am</h3>
            <h1>Md. Sorup Rohan</h1>
            <p>Undergraduate Student,<br> Computer Science and Engineering</p>

            <div class="social-media">
                <a href="https://github.com/soruprohan" target="_blank"><i class='bx bxl-github'></i></a>
                <a href="https://www.linkedin.com/in/soruprohan" target="_blank"><i class='bx bxl-linkedin'></i></a>
                <a href="https://www.facebook.com/soruprohan" target="_blank"><i class='bx bxl-facebook'></i></a>
                <a href="https://www.instagram.com/sorup_rohan" target="_blank"><i class='bx bxl-instagram-alt'></i></a>

            </div>
            <a href="assets/sorupCV.pdf" class="btn" target="_blank">Download CV</a>
        </div>

        <div class="profession-container">
            <div class="profession-box">

                <div class="profession" style="--i:0;">
                    <i class='bx bxs-graduation'></i>
                    <h3>Student</h3>
                </div>

                <div class="profession" style="--i:1;">
                    <i class='bx bx-code-alt'></i>
                    <h3>Web Developer</h3>
                </div>

                <div class="profession" style="--i:2;">
                    <i class='bx bx-chip'></i>
                    <h3>ML Enthusiast</h3>
                </div>

                <div class="profession" style="--i:3;">
                    <i class='bx bxs-edit-alt'></i>
                    <h3>Problem Solver</h3>
                </div>

                <div class="circle"></div>
            </div>

            <div class="overlay"></div>

            <!--There is some issues on this image part from video-->
            <div class="home-img">
                <img src="assets/formal_pic-Photoroom.png" alt="Home image">
            </div>

        </div>

    </section>

    <!--about section design-->
    <section class="about" id="about">

        <div class="about-img">
            <img src="assets/central_viva_pic.jpg" alt="about image">
        </div>

        <div class="about-content">
            <h2 class="heading">About <span>Me</span></h2>
            <p>
                I'm currently completing my Bachelor's degree in Computer Science and Engineering at <b>Khulna
                    University of Engineering
                    & Technology</b>(<a href="https://www.kuet.ac.bd" target="_blank"><i>KUET</i></a>). I'm passionate
                about problem solving, machine learning, data science, and
                full-stack development. I’ve developed several applications and websites for desktop & mobile. I'm
                always eager to learn, collaborate, and take on new challenges
                that help me grow as a developer.
            </p>

            <a href="#" class="btn">Read More</a>
        </div>

    </section>


    <!-- education section design -->
    <section class="education" id="education">
        <h2 class="heading"> Education</h2>

        <div class="education-container">
            <?php foreach ($education_rows as $edu): ?>
                <div class="education-box">
                    <h3><?= htmlspecialchars($edu['degree']) ?></h3>
                    <p><?= htmlspecialchars($edu['institution'] . (!empty($edu['location']) ? ', ' . $edu['location'] : '')) ?></p>
                    <span class="education-year">
                        <?= htmlspecialchars($edu['start_year']) ?> – <?= htmlspecialchars($edu['end_year']) ?>
                    </span>
                    <?php if (!empty($edu['description'])): ?>
                        <p><?= nl2br(htmlspecialchars($edu['description'])) ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </section>


    <!--experience section design-->
    <section class="experience" id="experience">
        <h2 class="heading">My <span>Experience</span></h2>

        <div class="experience-container">
            <div class="experience-box">
                <i class='bx bx-code-alt'></i>
                <h3>Web Development</h3>
                <p> I've built several responsive and interactive websites using HTML,
                    CSS, JavaScript, and modern frameworks. My focus has been on creating clean UI/UX and
                    writing maintainable code for personal and academic projects.</p>
                <!-- <a href="#" class="btn">Read More</a> -->
            </div>

            <div class="experience-box">
                <i class='bx bxs-paint'></i>
                <h3>Graphics Design</h3>
                <p>I've explored visual creativity through designing logos, banners, and UI mockups using tools like
                    Figma and Photoshop. My design work reflects a minimal yet effective style, often integrated into my
                    web development projects.</p>
                <!-- <a href="#" class="btn">Read More</a> -->
            </div>

            <div class="experience-box">
                <i class='bx bx-bar-chart-alt'></i>
                <h3>Machine Learning</h3>
                <p>With a growing interest in AI, I've worked on basic machine learning projects involving
                    classification and regression. Using Python, pandas, scikit-learn, and matplotlib, I've trained
                    models as part of personal exploration.</p>
                <!-- <a href="#" class="btn">Read More</a> -->
            </div>

        </div>
    </section>

    <!--portfolio section design-->
    <section class="portfolio" id="portfolio">
        <h2 class="heading">Latest <span>Projects</span></h2>

        <div class="portfolio-container">
            <?php foreach ($project_rows as $pr): ?>
                <div class="portfolio-box">
                    <?php if (!empty($pr['image_path'])): ?>
                        <img src="<?= htmlspecialchars($pr['image_path']) ?>" alt="">
                    <?php endif; ?>
                    <div class="portfolio-layer">
                        <h4><?= htmlspecialchars($pr['title']) ?></h4>
                        <?php if (!empty($pr['description'])): ?>
                            <p><?= nl2br(htmlspecialchars($pr['description'])) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($pr['project_url']) || !empty($pr['repo_url'])): ?>
                            <a href="<?= htmlspecialchars($pr['project_url'] ?: $pr['repo_url']) ?>" target="_blank"><i class='bx bx-link-external'></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </section>

    <!--testimonial design-->
    <div class="testimonial-container">
        <h2 class="heading">Activities <span>& Achievements</span></h2>

        <div class="testimonial-wrapper">
            <div class="testimonial-box mySwiper">
                <div class="testimonial-content swiper-wrapper">

                    <?php if (empty($testimonial_rows)): ?>
                        <!-- Fallback content when no testimonials in database -->
                        <div class="testimonial-slide swiper-slide">
                            <img src="assets/deans_award.jpg" alt="">
                            <h3>Dean's Award</h3>
                            <p>Recipient of the <b>Dean's Award</b> for graduating with First Class Honours in all two academic years so far, reflecting consistent
                                academic excellence and dedication.</p>
                        </div>

                        <div class="testimonial-slide swiper-slide">
                            <img src="assets/ikpc.jpg" alt="">
                            <h3>Intra Kuet Programming Contest</h3>
                            <p>Participated in the <b>Intra Kuet Programming Contest 2023</b>, demonstrating strong analytical and programming skills in a competitive environment.</p>
                        </div>

                        <div class="testimonial-slide swiper-slide">
                            <img src="assets/computer-program-coding-screen.jpg" alt="">
                            <h3>Club Activities</h3>
                            <p>Active member of <b>SGIPC, KUET</b> and <b>HACK, KUET</b> which are clubs for students dedicated to competitive programming and hardware acceleration.</p>
                        </div>
                    <?php else: ?>
                        <!-- Dynamic content from database -->
                        <?php foreach ($testimonial_rows as $testimonial): ?>
                            <div class="testimonial-slide swiper-slide">
                                <?php if (!empty($testimonial['image_path'])): ?>
                                    <img src="<?= htmlspecialchars($testimonial['image_path']) ?>" alt="">
                                <?php endif; ?>
                                <h3><?= htmlspecialchars($testimonial['title']) ?></h3>
                                <p><?= nl2br(htmlspecialchars($testimonial['description'])) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
    <!-- Skill section design -->

    <section class="skills-section" id="skills-section">
        <div class="container">
            <h2 class="section-title">Skills & <span>Expertise</span></h2>
            <div class="skills-container">
                <!-- Categories Sidebar -->
                <div class="categories-sidebar">
                    <h3>Categories</h3>
                    <div class="category-list">
                        <div class="category-item active" data-category="programming">
                            <div class="category-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="16,18 22,12 16,6"></polyline>
                                    <polyline points="8,6 2,12 8,18"></polyline>
                                </svg>
                            </div>
                            <span>Programming Languages</span>
                        </div>
                        <div class="category-item" data-category="frontend">
                            <div class="category-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                    <line x1="8" y1="21" x2="16" y2="21"></line>
                                    <line x1="12" y1="17" x2="12" y2="21"></line>
                                </svg>
                            </div>
                            <span>Frontend Development</span>
                        </div>
                        <div class="category-item" data-category="backend">
                            <div class="category-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                    <line x1="8" y1="21" x2="16" y2="21"></line>
                                    <line x1="12" y1="17" x2="12" y2="21"></line>
                                </svg>
                            </div>
                            <span>Backend Development</span>
                        </div>
                        <div class="category-item" data-category="ai">
                            <div class="category-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path
                                        d="M12 1v6m0 6v6m11-7h-6m-6 0H1m15.5-6.5l-4.24 4.24m-6.36 0L1.5 5.5m17 13l-4.24-4.24m-6.36 0L1.5 18.5">
                                    </path>
                                </svg>
                            </div>
                            <span>Artificial Intelligence</span>
                        </div>
                        <div class="category-item" data-category="cloud">
                            <div class="category-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path>
                                </svg>
                            </div>
                            <span>Cloud & DevOps</span>
                        </div>
                        <div class="category-item" data-category="additional">
                            <div class="category-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                    <line x1="8" y1="21" x2="16" y2="21"></line>
                                    <line x1="12" y1="17" x2="12" y2="21"></line>
                                </svg>
                            </div>
                            <span>Additional Skills</span>
                        </div>
                        <div class="category-item" data-category="languages">
                            <div class="category-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M8 12h8m-8 0a8 8 0 0 1 8 0m-8 0a8 8 0 0 0 8 0"></path>
                                </svg>
                            </div>
                            <span>Languages</span>
                        </div>
                    </div>
                </div>

                <!-- Skills Content -->
                <div class="skills-content">
                    <!-- Programming Languages -->
                    <div class="skills-category active" id="programming">
                        <div class="category-header">
                            <div class="category-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="16,18 22,12 16,6"></polyline>
                                    <polyline points="8,6 2,12 8,18"></polyline>
                                </svg>
                            </div>
                            <h3>Programming Languages</h3>
                        </div>
                        <div class="skills-grid">
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">JavaScript</span>
                                    <span class="skill-experience">1+ years</span>
                                    <span class="skill-percentage">90%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="90"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Python</span>
                                    <span class="skill-experience">3+ years</span>
                                    <span class="skill-percentage">88%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="88"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">TypeScript</span>
                                    <span class="skill-experience">1+ years</span>
                                    <span class="skill-percentage">85%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="85"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">JAVA</span>
                                    <span class="skill-experience">Academic</span>
                                    <span class="skill-percentage">50%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="50"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">C#</span>
                                    <span class="skill-experience">Academic</span>
                                    <span class="skill-percentage">50%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="50"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">C++</span>
                                    <span class="skill-experience">3+ years</span>
                                    <span class="skill-percentage">50%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="50"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">C</span>
                                    <span class="skill-experience">3+ years</span>
                                    <span class="skill-percentage">50%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="50"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Frontend Development -->
                    <div class="skills-category" id="frontend">
                        <div class="category-header">
                            <div class="category-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                    <line x1="8" y1="21" x2="16" y2="21"></line>
                                    <line x1="12" y1="17" x2="12" y2="21"></line>
                                </svg>
                            </div>
                            <h3>Frontend Development</h3>
                        </div>
                        <div class="skills-grid">
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">React.js</span>
                                    <span class="skill-experience">6+ months</span>
                                    <span class="skill-percentage">92%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="92"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Next.js</span>
                                    <span class="skill-experience">6+ months</span>
                                    <span class="skill-percentage">90%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="90"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">HTML</span>
                                    <span class="skill-experience">3+ years</span>
                                    <span class="skill-percentage">95%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="95"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">CSS</span>
                                    <span class="skill-experience">3+ years</span>
                                    <span class="skill-percentage">80%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="80"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">UI/UX Design</span>
                                    <span class="skill-experience"></span>
                                    <span class="skill-percentage">75%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="75"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Figma</span>
                                    <span class="skill-experience">1+ years</span>
                                    <span class="skill-percentage">70%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="70"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Responsive Design</span>
                                    <span class="skill-experience"></span>
                                    <span class="skill-percentage">85%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="85"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Backend Development -->
                    <div class="skills-category" id="backend">
                        <div class="category-header">
                            <div class="category-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                    <line x1="8" y1="21" x2="16" y2="21"></line>
                                    <line x1="12" y1="17" x2="12" y2="21"></line>
                                </svg>
                            </div>
                            <h3>Backend Development</h3>
                        </div>
                        <div class="skills-grid">
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Node.js</span>
                                    <span class="skill-experience">1+ years</span>
                                    <span class="skill-percentage">85%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="85"></div>
                                </div>
                            </div>


                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Python</span>
                                    <span class="skill-experience">3+ years</span>
                                    <span class="skill-percentage">88%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="88"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">SQL</span>
                                    <span class="skill-experience">1+ years</span>
                                    <span class="skill-percentage">85%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="85"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Artificial Intelligence -->
                    <div class="skills-category" id="ai">
                        <div class="category-header">
                            <div class="category-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path
                                        d="M12 1v6m0 6v6m11-7h-6m-6 0H1m15.5-6.5l-4.24 4.24m-6.36 0L1.5 5.5m17 13l-4.24-4.24m-6.36 0L1.5 18.5">
                                    </path>
                                </svg>
                            </div>
                            <h3>Artificial Intelligence</h3>
                        </div>
                        <div class="skills-grid">
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Machine Learning</span>
                                    <span class="skill-experience">2+ years</span>
                                    <span class="skill-percentage">80%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="80"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">TensorFlow</span>
                                    <span class="skill-experience">2+ years</span>
                                    <span class="skill-percentage">75%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="75"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">PyTorch</span>
                                    <span class="skill-experience">1+ year</span>
                                    <span class="skill-percentage">70%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="70"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Cloud & DevOps -->
                    <div class="skills-category" id="cloud">
                        <div class="category-header">
                            <div class="category-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path>
                                </svg>
                            </div>
                            <h3>Cloud & DevOps</h3>
                        </div>
                        <div class="skills-grid">
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">AWS</span>
                                    <span class="skill-experience">2+ years</span>
                                    <span class="skill-percentage">75%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="75"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Docker</span>
                                    <span class="skill-experience">2+ years</span>
                                    <span class="skill-percentage">70%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="70"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Git</span>
                                    <span class="skill-experience">4+ years</span>
                                    <span class="skill-percentage">90%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="90"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Additional Skills -->
                    <div class="skills-category" id="additional">
                        <div class="category-header">
                            <div class="category-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                    <line x1="8" y1="21" x2="16" y2="21"></line>
                                    <line x1="12" y1="17" x2="12" y2="21"></line>
                                </svg>
                            </div>
                            <h3>Additional Skills</h3>
                        </div>
                        <div class="skills-grid">
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Problem Solving</span>
                                    <span class="skill-experience">4+ years</span>
                                    <span class="skill-percentage">95%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="95"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Team Leadership</span>
                                    <span class="skill-experience">1+ years</span>
                                    <span class="skill-percentage">85%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="85"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Project Management</span>
                                    <span class="skill-experience">1+ years</span>
                                    <span class="skill-percentage">80%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="80"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Languages -->
                    <div class="skills-category" id="languages">
                        <div class="category-header">
                            <div class="category-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M8 12h8m-8 0a8 8 0 0 1 8 0m-8 0a8 8 0 0 0 8 0"></path>
                                </svg>
                            </div>
                            <h3>Languages</h3>
                        </div>
                        <div class="skills-grid">
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">Bengali</span>
                                    <span class="skill-experience">Native</span>
                                    <span class="skill-percentage">100%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="100"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span class="skill-name">English</span>
                                    <span class="skill-experience">Fluent</span>
                                    <span class="skill-percentage">95%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-width="95"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="index.js"></script>


    <!-- contact section design -->
    <section class="contact" id="contact">
        <h2 class="heading">Contact <span>Me!</span></h2>
        <p>
            <i class='bx bxs-envelope'></i>
            Email : <a href="mailto:sorupr5@gmail.com">sorupr5@gmail.com</a>
        </p>

        <form action="https://formsubmit.co/sorupr5@gmail.com" method="POST">
            <!-- <input type="hidden" name="access_key" value="9d4a2fd3-749c-48eb-8f7c-ccdbecff4e75"> -->

            <div class="input-box">
                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>

            <div class="input-box">
                <input type="tel" name="mobile_number" placeholder="Mobile Number">
                <input type="text" name="subject" placeholder="Email Subject">
            </div>

            <textarea name="message" cols="30" rows="10" placeholder="Your Message" required></textarea>

            <input type="submit" value="Send Message" class="btn">
        </form>
    </section>


    <!--footer design-->
    <footer class="footer">
        <div class="footer-text">
            <p>Copyright &copy; 2025 by Md. Sorup Rohan | All Rights Reserved.</p>
        </div>

        <div class="footer-iconTop">
            <a href="#home"><i class='bx bx-up-arrow-alt'></i></a>
        </div>
    </footer>

    <!--scroll reveal-->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!--swiper js-->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!--custom js-->
    <script src="script.js"></script>
</body>

</html>