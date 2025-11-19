import { useState } from "react";
import Header from "../components/Header";
import Footer from "../components/Footer";
import CourseCard from "../components/CourseCard";
import "../styles/ExploreCourses.css";

const courses = [
  { title: "React for Beginners", description: "Learn React step by step", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "Advanced Python", description: "Deep dive into Python", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "Machine Learning", description: "Intro to ML concepts", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "UI/UX Basics", description: "Design better UI", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "JavaScript Mastery", description: "Master JS", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "Node.js Crash Course", description: "Backend with Node", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "Cybersecurity 101", description: "Basics of security", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "SQL for Beginners", description: "Learn SQL", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "Docker Essentials", description: "Intro to Docker", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "AI Fundamentals", description: "Basics of AI", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "Cloud Computing", description: "Cloud basics", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "Data Structures", description: "Algorithms & Structures", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
];

const ITEMS_PER_PAGE = 9;

const ExploreCourses = () => {
  const [currentPage, setCurrentPage] = useState(1);

  const totalPages = Math.ceil(courses.length / ITEMS_PER_PAGE);

  const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
  const currentCourses = courses.slice(startIndex, startIndex + ITEMS_PER_PAGE);

  const goToPage = (page) => {
    if (page >= 1 && page <= totalPages) setCurrentPage(page);
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  };

  return (
    <>
      <Header />

      <div className="explore-page">

        <h1 className="explore-title">Explore Courses</h1>

        <div className="explore-grid">
          {currentCourses.map((course, idx) => (
            <CourseCard key={idx} course={course} />
          ))}
        </div>

        <div className="pagination">
          <button 
            className="page-arrow" 
            onClick={() => goToPage(currentPage - 1)}
            disabled={currentPage === 1}
          >
            ‹
          </button>

          {[...Array(totalPages)].map((_, i) => (
            <button
              key={i}
              className={`page-number ${currentPage === i + 1 ? "active" : ""}`}
              onClick={() => goToPage(i + 1)}
            >
              {i + 1}
            </button>
          ))}

          <button
            className="page-arrow"
            onClick={() => goToPage(currentPage + 1)}
            disabled={currentPage === totalPages}
          >
            ›
          </button>
        </div>
      </div>

      <Footer />
    </>
  );
};

export default ExploreCourses;
