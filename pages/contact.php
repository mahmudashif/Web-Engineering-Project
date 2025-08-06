<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Orebi - Contact Us</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/contact.css" />
    <script src="../components/components.js"></script>
  </head>
  <body>
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <!-- Hero Section -->
    <section class="contact-hero">
      <div class="container">
        <h1>Get in Touch</h1>
        <p>We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
      </div>
    </section>

    <!-- Contact Info Section -->
    <section class="contact-info-section">
      <div class="container">
        <div class="contact-info-grid">
          <div class="info-card">
            <div class="info-icon">📍</div>
            <h3>Visit Us</h3>
            <p>Mirpur-1<br>Dhaka 1216<br>Bangladesh</p>
          </div>
          <div class="info-card">
            <div class="info-icon">📞</div>
            <h3>Call Us</h3>
            <p>+1 (555) 123-4567<br>Mon - Fri: 9AM - 6PM EST<br>Weekend: 10AM - 4PM EST</p>
          </div>
          <div class="info-card">
            <div class="info-icon">✉️</div>
            <h3>Email Us</h3>
            <p>support@orebi.com<br>sales@orebi.com<br>info@orebi.com</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
      <div class="container">
        <div class="contact-content">
          <div class="contact-text">
            <h2>Send us a Message</h2>
            <p>Have a question about our products or services? Need help with an order? We're here to help!</p>
            
            <div class="contact-features">
              <div class="feature">
                <span class="feature-icon">⚡</span>
                <div>
                  <h4>Quick Response</h4>
                  <p>We typically respond within 24 hours</p>
                </div>
              </div>
              <div class="feature">
                <span class="feature-icon">🎯</span>
                <div>
                  <h4>Expert Support</h4>
                  <p>Our team is knowledgeable and ready to help</p>
                </div>
              </div>
            </div>
          </div>

          <div class="contact_main">
            <div class="form_main">
              <h2>Fill up the form</h2>
              <form class="contact_form">
                <label>Your Name</label>
                <input type="text" placeholder="Your name" required />

                <label>Your Email</label>
                <input type="email" placeholder="Your email" required />

                <label>Your Message</label>
                <textarea placeholder="Your message" required></textarea>

                <button type="submit">Send Message</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
      <div class="container">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-grid">
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <h4>How long does shipping take?</h4>
              <span class="faq-toggle">+</span>
            </button>
            <div class="faq-answer">
              <p>Standard shipping takes 3-5 business days. Express shipping is available for 1-2 day delivery.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <h4>What is your return policy?</h4>
              <span class="faq-toggle">+</span>
            </button>
            <div class="faq-answer">
              <p>We offer a 30-day return policy for all unused items in original packaging.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <h4>Do you ship internationally?</h4>
              <span class="faq-toggle">+</span>
            </button>
            <div class="faq-answer">
              <p>Yes, we ship to over 50 countries worldwide with tracking available.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <h4>How can I track my order?</h4>
              <span class="faq-toggle">+</span>
            </button>
            <div class="faq-answer">
              <p>You'll receive a tracking number via email once your order ships.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>
    
    <script>
      function toggleFaq(button) {
        const answer = button.nextElementSibling;
        const isActive = button.classList.contains('active');
        
        // Close all other FAQ items
        document.querySelectorAll('.faq-question').forEach(q => {
          q.classList.remove('active');
          q.nextElementSibling.classList.remove('active');
        });
        
        // Toggle current item
        if (!isActive) {
          button.classList.add('active');
          answer.classList.add('active');
        }
      }
    </script>
  </body>
</html>
