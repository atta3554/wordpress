// Import Sass
import './styles/customizedBootstrap.scss';



// Impor Modules
import Search from './modules/Search';
import Notes from './modules/myNotes';
import Like from './modules/professorLike';
import Menu from './modules/MobileMenu';
import SwiperSlider from './modules/eventsSlider'


// create instance
const menu = new Menu() 
const search = new Search() 
const notes = new Notes()
const like = new Like()
const swiper = new SwiperSlider()
