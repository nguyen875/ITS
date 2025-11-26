import CourseCard from "../components/CourseCard";
import "../styles/Homepage.css";
import Header from "../components/Header";
import Footer from "../components/Footer";

const courses = [
  {
    title: "Instagram Marketing Hacks",
    description: "Enhancing Learning Engagement through thoughtful UI/UX",
    //color: "linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%)",
  },
  {
    title: "Google Adsense Hacks",
    description: "Enhancing Learning Engagement through thoughtful UI/UX",
    //color: "linear-gradient(135deg, #fbc7a4 0%, #f9d3b4 100%)",
  },
  {
    title: "Hit A Backhand Like Pro",
    description: "Enhancing Learning Engagement through thoughtful UI/UX",
    //color: "linear-gradient(135deg, #f9c1d9 0%, #fbc4d9 100%)",
  },
];

const Homepage = () => {
  return (
    <>
      <Header />

      <div className="homepage">
        {/* Hero Section */}
        <section className="hero">
          <h1>Welcome to EduFlow</h1>
          <p>Learn new skills online and improve your career</p>
          <a href="/explore-courses" className="hero-btn">Explore Courses</a>
        </section>

        {/* Courses Section */}
        <section className="courses-section">
          <h2>Featured Courses</h2>
          <div className="courses-grid">
            {courses.map((course, idx) => (
              <CourseCard
                key={idx}
                course={course}
                //color={course.color} // passe la couleur au composant
              />
            ))}
          </div>
        </section>
      </div>

      <Footer />
    </>
  );
};

export default Homepage;
