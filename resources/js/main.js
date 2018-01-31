import '../css/main.css'

const helloES6World = () => {
  // Quick test to see if we can build and include JS.
  // This will throw in IE8 if we have not polyfilled
  // Array.from().
  const array = Array.from('hello world')
  console.log(array.join(''))
}
