import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Header from "./components/Header";
import Footer from "./components/Footer";
import Homepage from "./pages/Homepage";
import Login from "./components/Login";
import SignUp from "./components/SignUp";
import ForgotPassword from "./components/ForgotPassword";

const App = () => {
  return (
    // <Router>
    //   <Header />
    //   <Routes>
    //     <Route path="/" element={<Homepage />} />
    //   </Routes>
    //   <Footer />
    // </Router>
    <>
      <SignUp />
    </>
  );
};

export default App
