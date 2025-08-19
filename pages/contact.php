<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - Gadget Shop | Get Support & Assistance</title>
    <meta name="description" content="Get in touch with Gadget Shop for product support, order assistance, or any questions. We're here to help with fast, professional customer service.">
    <link rel="stylesheet" href="../assets/css/contact-minimal.css" />
    <script src="../components/components.js"></script>
  </head>
  <body>
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <!-- Hero Section -->
    <section class="contact-hero">
      <div class="container">
        <div class="hero-content">
          <span class="hero-badge">Customer Support</span>
          <h1>How can we help you?</h1>
          <p>We're here to assist with orders, technical support, and product inquiries.</p>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="contact-main">
      <div class="container">
        <div class="contact-grid">
          
          <!-- Contact Form -->
          <div class="form-container">
            <div class="form-header">
              <h2>Send us a message</h2>
              <p>Fill out the form below and we'll get back to you within 24 hours</p>
            </div>
            
            <form class="contact-form">
              <div class="form-row">
                <div class="form-group">
                  <label for="firstName">First Name</label>
                  <input type="text" id="firstName" name="firstName" required>
                </div>
                <div class="form-group">
                  <label for="lastName">Last Name</label>
                  <input type="text" id="lastName" name="lastName" required>
                </div>
              </div>
              
              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
              </div>
              
              <div class="form-group">
                <label for="subject">Subject</label>
                <select id="subject" name="subject" required>
                  <option value="">Select a topic</option>
                  <option value="order">Order Support</option>
                  <option value="product">Product Inquiry</option>
                  <option value="technical">Technical Support</option>
                  <option value="return">Returns & Refunds</option>
                  <option value="other">Other</option>
                </select>
              </div>
              
              <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" placeholder="Please provide details about your inquiry..." required></textarea>
              </div>
              
              <button type="submit" class="submit-btn">
                <span>Send Message</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M22 2L11 13"/>
                  <path d="M22 2L15 22L11 13L2 9L22 2Z"/>
                </svg>
              </button>
            </form>
          </div>

          <!-- Contact Information -->
          <div class="info-container">
            <div class="info-section">
              <h3>Get in touch</h3>
              <p>Choose the best way to reach us</p>
            </div>

            <div class="contact-methods">
              <div class="contact-method">
                <div class="method-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                  </svg>
                </div>
                <div class="method-content">
                  <h4>Email Support</h4>
                  <p>support@gadgetshop.com</p>
                  <span>Response within 24 hours</span>
                </div>
              </div>

              <div class="contact-method">
                <div class="method-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                  </svg>
                </div>
                <div class="method-content">
                  <h4>Phone Support</h4>
                  <p>+1 (555) 123-4567</p>
                  <span>Mon-Fri 9AM-6PM EST</span>
                </div>
              </div>

              <div class="contact-method">
                <div class="method-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                  </svg>
                </div>
                <div class="method-content">
                  <h4>Visit Us</h4>
                  <p>Mirpur-1, Dhaka 1216</p>
                  <span>Bangladesh</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
      <div class="container">
        <div class="faq-header">
          <h2>Frequently Asked Questions</h2>
          <p>Find answers to the most common questions about our products and services</p>
        </div>
        
        <div class="faq-container">
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>How long does shipping take?</span>
              <svg class="faq-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6"/>
              </svg>
            </button>
            <div class="faq-answer">
              <p>Standard shipping takes 3-5 business days within the US. Express shipping (1-2 days) is available for an additional fee. International shipping times vary by location but typically take 7-14 business days.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>What is your return policy?</span>
              <svg class="faq-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6"/>
              </svg>
            </button>
            <div class="faq-answer">
              <p>We offer a 30-day return policy for all unused items in original packaging. Items must be returned in new condition with all accessories and documentation. Return shipping is free for defective items.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>Do you offer international shipping?</span>
              <svg class="faq-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6"/>
              </svg>
            </button>
            <div class="faq-answer">
              <p>Yes, we ship to over 50 countries worldwide. International shipping rates and delivery times vary by destination. All international orders include tracking and customs declaration.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>How can I track my order?</span>
              <svg class="faq-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6"/>
              </svg>
            </button>
            <div class="faq-answer">
              <p>You'll receive a tracking number via email within 24 hours of shipment. You can track your order on our website or directly through the carrier's website using the provided tracking number.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>What payment methods do you accept?</span>
              <svg class="faq-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6"/>
              </svg>
            </button>
            <div class="faq-answer">
              <p>We accept all major credit cards (Visa, MasterCard, American Express), PayPal, Apple Pay, Google Pay, and bank transfers. All payments are processed securely with SSL encryption.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>Do your products come with warranty?</span>
              <svg class="faq-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6"/>
              </svg>
            </button>
            <div class="faq-answer">
              <p>Yes, all our products come with manufacturer warranty. Warranty periods vary by product and brand, typically ranging from 1-3 years. We also offer extended warranty options for extended coverage.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>
    
    <script>
      function toggleFaq(button) {
        const faqItem = button.parentElement;
        const answer = button.nextElementSibling;
        const icon = button.querySelector('.faq-icon');
        const isActive = faqItem.classList.contains('active');
        
        // Close all other FAQ items
        document.querySelectorAll('.faq-item').forEach(item => {
          if (item !== faqItem) {
            item.classList.remove('active');
            item.querySelector('.faq-answer').style.maxHeight = '0px';
            item.querySelector('.faq-icon').style.transform = 'rotate(0deg)';
          }
        });
        
        // Toggle current item
        if (!isActive) {
          faqItem.classList.add('active');
          answer.style.maxHeight = answer.scrollHeight + 'px';
          icon.style.transform = 'rotate(180deg)';
        } else {
          faqItem.classList.remove('active');
          answer.style.maxHeight = '0px';
          icon.style.transform = 'rotate(0deg)';
        }
      }
    </script>
  </body>
</html>
