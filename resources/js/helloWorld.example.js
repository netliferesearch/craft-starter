export default function helloWorld() {
  // silly es6 test, Array.from is a hard thing to do for browsers like IE.
  const sillyTest = Array.from(['hello', 'world']).join(' ')
  console.log(sillyTest)
}
