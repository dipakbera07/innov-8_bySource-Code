import './style.css'
import products from "./api/products.json";
import { showProductContainer } from './homeProductCards';


//calling functions to display all the products.
showProductContainer(products);
