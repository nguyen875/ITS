import { useState } from "react";
import Header from "../components/Header";
import Footer from "../components/Footer";
import CourseCard from "../components/CourseCard";
import "../styles/ExploreCourses.css";

const courses = [
  { title: "React for Beginners", description: "Learn React step by step"},
  { title: "Advanced Python", description: "Deep dive into Python" },
  { title: "Machine Learning", description: "Intro to ML concepts" },
  { title: "UI/UX Basics", description: "Design better UI" },
  { title: "JavaScript Mastery", description: "Master JS" },
  { title: "Node.js Crash Course", description: "Backend with Node" },
  { title: "Cybersecurity 101", description: "Basics of security" },
  { title: "SQL for Beginners", description: "Learn SQL" },
  { title: "Docker Essentials", description: "Intro to Docker" },
  { title: "AI Fundamentals", description: "Basics of AI" },
  { title: "Cloud Computing", description: "Cloud basics" },
  { title: "Data Structures", description: "Algorithms & Structures" },
];

const ITEMS_PER_PAGE = 9;

const ExploreCourses = () => {
  const [currentPage, setCurrentPage] = useState(1);
  const totalPages = Math.ceil(courses.length / ITEMS_PER_PAGE);

  const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
  const currentCourses = courses.slice(startIndex, startIndex + ITEMS_PER_PAGE);

  const goToPage = (page) => {
    if (page >= 1 && page <= totalPages) setCurrentPage(page);
    window.scrollTo({ top: 0, behavior: "smooth" });
  };

  return (
    <>
      <Header />

      <div className="explore-page">
        <h1 className="explore-title">Explore Courses</h1>

        <div className="explore-grid">
          {currentCourses.map((course, idx) => (
            <CourseCard
              key={idx}
              course={course}
            />
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
