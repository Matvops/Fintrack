import { DateContextProvider } from "./contexts/DateContextProvider"
import { UserContextProvider } from "./contexts/UserContextProvider"
import { MainRouter } from "./routers/MainRouter"
import { ToastWrapper } from "./wrappers/ToastWrapper"

function App() {

  return (
    <UserContextProvider>
      <DateContextProvider>
        <ToastWrapper>
          <MainRouter />
        </ToastWrapper>
      </DateContextProvider>
    </UserContextProvider>
  )
}

export default App
