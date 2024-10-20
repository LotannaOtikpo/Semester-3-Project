import React, { useEffect, useState } from 'react';
import axios from 'axios';
import './App.css';  
import CEO from './images/ceo.jpg';
import COO from './images/coo.jpg';
import Developer from './images/developer.jpg';
import About from './images/about.mp4';
import SmoothScroll from "smooth-scroll";

// Initialize smooth scroll for navigation links
export const scroll = new SmoothScroll('a[href*="#"]', {
  speed: 1000,
  speedAsDuration: true,
});

function App() {

  // State variables for home, about, and services sections
// the useState hooks here manage the state for the home, about, and services data
const [homeData, setHomeData] = useState({ title: '', subtitle: '', description: '' });
const [aboutData, setAboutData] = useState({ title: '', content: '' });
const [servicesData, setServicesData] = useState([]);

// Fetch home section data from the backend
// Makes an asynchronous request to retrieve home section details (title, subtitle, and description)
const fetchHomeData = async () => {
  try {
    const response = await axios.get('http://localhost/ViTO-Project/backend/get_home_data.php');  // API call to fetch data
    setHomeData(response.data);  // Update state with fetched data
  } catch (error) {
    console.error('Error fetching home data:', error);  // Log any error that occurs during the fetch
  }
};

// Fetch about section data from the backend
// This function fetches the content for the "About Us" section
const fetchAboutData = async () => {
  try {
    const response = await axios.get('http://localhost/ViTO-Project/backend/get_about_data.php'); 
    setAboutData(response.data);  
  } catch (error) {
    console.error('Error fetching about data:', error); 
  }
};

// Fetch services section data from the backend
// This function fetches the details for the "Services" section
const fetchServicesData = async () => {
  try {
    const response = await axios.get('http://localhost/ViTO-Project/backend/get_services_data.php'); 
    setServicesData(response.data);  
  } catch (error) {
    console.error('Error fetching services data:', error);  
  }
};

// useEffect to trigger data fetching when the component mounts
// This hook ensures that the fetch functions are called when the component is first rendered
useEffect(() => {
  fetchHomeData();     // Fetch home section data
  fetchAboutData();    // Fetch about section data
  fetchServicesData(); // Fetch services section data
}, []);  // Empty dependency array ensures this runs only once on mount

  return (
<div className="App">



      {/* Navbar */}
      {/* Navbar */}
      {/* Navbar */}
        <header className="navbar">
          <div className="logo">
            <b><a href="#home"><u>ViTO</u><p>BUSINESS</p></a></b>
          </div>
          <ul className="nav-links">
            <li><a href="#home">HOME</a></li>
            <li><a href="#about">ABOUT US</a></li>
            <li><a href="#services">SERVICES</a></li>
            <li><a href="#team">TEAM</a></li>
            <li><a href="#contact">CONTACT</a></li>
          </ul>
          <div className="buttons">
            <button className="signup-button" onClick={() => window.location.href = 'http://localhost/ViTO-Project/backend/signup.php'}>Signup</button>
            <button className="logout-button" onClick={() => window.location.href = 'http://localhost/ViTO-Project/backend/logout.php'}>Logout</button>
            <button className="admin-button" onClick={() => window.location.href = 'http://localhost/ViTO-Project/backend/admin/admin_login.php'}>Admin</button> 
          </div>
        </header>



      {/* Home Section */}
      {/* Home Section */}
      {/* Home Section */}
      <header id="home" className="home-section">
        <div className="home-text">
          <h1>{homeData.title || 'Welcome to ViTO BUSINESS'}</h1>
          <h2>{homeData.subtitle || 'Consolidated Synergy Limited'}</h2>
          <p>{homeData.description || '...improving lives through empowerments.'}</p>
          <a href="#about"><button className="btn-primary">View More</button></a>
        </div>
      </header>



      {/* Main Section */}
      {/* Main Section */}
      {/* Main Section */}

      <main>

        {/* About Section */}
        {/* About Section */}
        {/* About Section */}
        <section id="about" className="about-section">     
          <div className="about-section">  
            <h2>About Us</h2>   
            <h3>{aboutData.title || 'Few Words About Us'}</h3>
            <p>{aboutData.content || 'ViTO Business Consolidated Synergy Limited is a Nigerian company...'}</p>

            <div className="about-features">
              <div className="about-icons">
                <h3>Empowering Communities</h3>
                <p>ViTO Business focuses on fostering economic growth by offering services and opportunities that uplift individuals and communities, empowering them to improve their livelihoods.</p>
              </div>
              <div className="about-icons">
                <h3>Innovative Solutions</h3>
                <p>The company drives innovation in real estate, logistics, and agriculture, using cutting-edge strategies to deliver sustainable solutions to its clients.</p>
              </div>
              <div className="about-icons">
                <h3>Commitment to Excellence</h3>
                <p>With a passion for quality, ViTO Business ensures excellence in every project, delivering consistent and high-value results for stakeholders.</p>
              </div>
            </div>
           
            {/* Video content */}
            <div className="about-video">
              <video width="500" height="300" controls autoPlay muted>
                <source src={About} type="video/mp4"></source>
                Your browser does not support the video tag.
              </video>
            </div>
          </div>
        </section>



        {/* Statistics Section */}
        {/* Statistics Section */}
        {/* Statistics Section */}
        <section id="statistics" className="statistics-section">
          <div className="container">  
            <div className="row">
              <div className="stat-item">
                <h3>500+</h3>
                <p>Projects Completed</p>
              </div>
              <div className="stat-item">
                <h3>20+</h3>
                <p>Awards Won</p>
              </div>
              <div className="stat-item">
                <h3>1,000,000+</h3>
                <p>Raised Nigerians</p>
              </div>
              <div className="stat-item">
                <h3>18 Years</h3>
                <p>Experience</p>
              </div>
            </div>
          </div>
        </section>



        {/* Services Section */}
        {/* Services Section */}
        {/* Services Section */}
          <section id="services" className="services-section">
            <h2>Our Services</h2>
            <div className="services-grid">
              {servicesData.length > 0 ? servicesData.map(service => (
                <div key={service.id} className="service-item">
                  <div className="services-icons">
                    {/* Add SVG icons here if needed */}
                  </div>
                  <h3>{service.title}</h3>
                  <p>{service.description}</p>
                </div>
              )) : (
                <p>No services available at the moment.</p>
              )}
            </div>
          </section>



        {/* Testimonial Section */}
        {/* Testimonial Section */}
        {/* Testimonial Section */}
        <section id="testimonial" className="testimonial-section">
          <h2>Testimonials</h2>
          <div className="testimonial-grid">

            <div className="testimonial-item">
              {/* Displaying the image of the testimonial source */}
              <div className="testimonial-image">
                <img src={COO} alt="Testimonial Image" />
              </div>
              {/* Displaying the testimonial text */}
              <div className="testimonial-text">
                <blockquote>
                  As the Chief Operating Officer of VITO, I initially approached the company's mission with cautious optimism. Given the challenges many businesses face in this sector, I was aware of the hurdles we would need to overcome. However, as we continued to build our team and develop innovative strategies, my confidence grew in our ability to not only meet but exceed expectations. The dedication and professionalism of our team are what truly set us apart in the industry. Today, I can proudly say that VITO is driving sustainable growth and delivering outstanding results for our clients. I wholeheartedly believe in our vision, and I encourage anyone looking to invest in transformative business solutions to partner with us.
                </blockquote>
                <p><strong>Toyin Sulyman</strong><br></br>Chief Operating Officer</p>
              </div>
            </div>

          </div>
        </section>



        {/* Team Section */}
        {/* Team Section */}
        {/* Team Section */}
        <section id="team" className="team-section">
          <h2>Our Team</h2>
          <div className="team-grid">
            <div className="team-member">
              {/* Displaying the image and name of the CEO */}
              <img src={CEO} alt="Image Description"></img>
              <h3>Anota Olugbenga Victor</h3>
                <p>Chief Executive Officer</p>
                <div class="social">
                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                        <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                      </svg></a>

                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                      </svg></a>

                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                      </svg></a>

                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
                      </svg></a>
                  </div>
            </div>

            <div className="team-member">
              {/* Displaying the image and name of the COO */}
              <img src={COO} alt="Image Description"></img>
              <h3>Sulyman Oluwatoyin</h3>
                <p>Chief Operating Officer</p>
                <div class="social">
                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                        <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                      </svg></a>

                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                      </svg></a>

                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                      </svg></a>

                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
                      </svg></a>
                  </div>
            </div>
            
            <div className="team-member">
              {/* Displaying the image and name of the Developer */}
              <img src={Developer} alt="Image Description"></img>
              <h3>Otikpo Lotanna</h3>
                <p>Programmer and Developer</p>
                <div class="social">
                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                        <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                      </svg></a>

                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                      </svg></a>

                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                      </svg></a>

                      <a href="#team"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
                      </svg></a>
                  </div>
            </div>
          </div>
        </section>



        {/* Contact Section */}
        {/* Contact Section */}
        {/* Contact Section */}
        <section id="contact" className="contact-section">
          <h1>Contact Us</h1>
          <br />
          <div className="contact-grid">
            {/* Contact form allowing users to submit their information */}
            <form>
              <input type="text" placeholder="Your Name" />
              <input type="email" placeholder="Your Email" />
              <input type="text" placeholder="Subject" />
              <textarea placeholder="Your Message"></textarea>
              <button type="submit">Send Message</button>
            </form>
          </div>
        </section>

      </main>



      {/* Footer */}
      {/* Footer */}
      {/* Footer */}
      <footer id="footer" className="footer">
        <div class="footer-content">
          {/* Address Section */}
          <div class="address">
            <h2>Address</h2>
            {/* Physical address of the company */}
            <p>House number 25, 4th Avenue, <br /> Gwarinpa Estate, Abuja.</p>
          </div>

          {/* Contact Information */}
          <div class="contact">
            <h2>Contact</h2>
            {/* Displaying email and phone numbers for contacting the company */}
            <p>Email: groupvitointernational@gmail.com <br/><br/>
              Phone: +234 904 280 7194 <br></br> +234 803 333 5013 <br></br> +234 813 217 7884
            </p>
          </div>

          {/* Placeholder for social media links */}
          <div class="socials">
            <h2>Follow Us</h2>
            <div class="social-links">

            <a href="#footer"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
              </svg></a>

              <a href="#footer"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
              </svg></a>

              <a href="#footer"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
              </svg></a>

              <a href="#footer"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
              </svg></a> 

            </div>
          </div>
        </div>

        {/* Footer Bottom */}
        <div class="footer-bottom">
            {/* Displaying copyright notice */}
            <p>© 2024 <b>ViTO Business Consolidated Synergy Limited.</b> All Rights Reserved.</p>
            {/* Developer credit */}
            <p>Developed by <a href="#footer" class="footer-link">Otikpo Lotanna.</a></p>
        </div>

        {/* Back-to-top button */}
        <div class="footer-button">
            <button class="back-to-top"><a href="#home">BACK TO TOP</a></button>
        </div>
      </footer>

</div>
  );
} 

export default App;