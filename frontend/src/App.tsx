import { MainRouter } from "./routers/MainRouter"
import { ToastWrapper } from "./wrappers/ToastWrapper"

function App() {

  return (
    <ToastWrapper>
      <MainRouter />
    </ToastWrapper>
  )
}

export default App
