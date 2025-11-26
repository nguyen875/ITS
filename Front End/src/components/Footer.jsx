import "../styles/Footer.css";

const Footer = () => {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="footer">
      <div className="footer-container">
        <p className="copyright">© {currentYear} MyTutor. All rights reserved.</p>
      </div>
    </footer>
  );
};

export default Footer;