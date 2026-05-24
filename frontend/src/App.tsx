import { UserContextProvider } from "./contexts/UserContextProvider"
import { MainRouter } from "./routers/MainRouter"
import { ToastWrapper } from "./wrappers/ToastWrapper"

function App() {

  return (
    <UserContextProvider>
      <ToastWrapper>
        <MainRouter />
      </ToastWrapper>
    </UserContextProvider>
  )
}

export default App
