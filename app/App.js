import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { NavigationContainer } from '@react-navigation/native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { SafeAreaView, StyleSheet, TouchableOpacity } from 'react-native';
import LoginScreen from './screens/LoginScreen';
import HomeScreen from './screens/HomeScreen';
import CameraScreen from './screens/CameraScreen';
import RegisterScreen from './screens/RegisterScreen';
import NoInternetScreen from './screens/NoInternetScreen';
import QRScreen from './screens/QRScreen';
import AuthContext from './contexts/AuthContexts';
import { loadUser, logout } from './services/AuthServices';
import { useState, useEffect } from 'react';
import SplashScreen from './screens/SplashScreen';
import Icon from 'react-native-vector-icons/FontAwesome';
import NetInfo from '@react-native-community/netinfo';

const Stack = createNativeStackNavigator();
const Tab = createBottomTabNavigator();

function HomeTabs({ user, handleLogout }) {
  return (
    <Tab.Navigator
      screenOptions={{
        tabBarStyle: { height: 70 },
        tabBarIconStyle: { size: 40 },
        tabBarLabelStyle: { fontSize: 14 },
        headerRight: () => (
          <TouchableOpacity onPress={handleLogout} style={{ paddingRight: 15 }}>
            <Icon name="sign-out" size={25} color="#ff6347" />
          </TouchableOpacity>
        ),
      }}
    >
      {/* {user?.role_id === 1 ? ( */}
        <Tab.Screen
          name="Scanner"
          component={CameraScreen}
          options={{
            tabBarIcon: ({ color }) => (
              <Icon name="camera" color={color} size={30} />
            ),
          }}
        />
      {/* ) : ( */}
        <>
          <Tab.Screen
            name="Home"
            component={HomeScreen}
            options={{
              tabBarIcon: ({ color }) => (
                <Icon name="home" color={color} size={40} />
              ),
            }}
          />
          <Tab.Screen
            name="QR"
            component={QRScreen}
            options={{
              tabBarIcon: ({ color }) => (
                <Icon name="qrcode" color={color} size={40} />
              ),
            }}
          />
        </>
      {/* )} */}
    </Tab.Navigator>
  );
}

export default function App() {
  const [user, setUser] = useState(null);
  const [status, setStatus] = useState("loading");
  const [isConnected, setConnected] = useState(true);


  useEffect(() => {
    async function runEffect() {
      try {
        const user = await loadUser();
        setUser(user);
      } catch (e) {
        // Handle error
      }
      setStatus("idle");
    }

    runEffect();
  }, []);

  useEffect(() => {
		const unsubscribe = NetInfo.addEventListener((state) => {
			setConnected(state.isConnected);
			if (!state.isConnected) {
				setStatus("noInternet");
			}
		});

		return () => {
			setStatus("idle");
		};
	}, []);

  const handleLogout = async () => {
    await logout();
    setUser(null);
  };

  if (status === "loading") {
    return <SplashScreen />;
  }

  if (status === "noInternet") {
    return <NoInternetScreen />;
  }

  return (
    <AuthContext.Provider value={{ user, setUser }}>
      <SafeAreaView style={styles.safeArea}>
        <NavigationContainer>
          <Stack.Navigator
            screenOptions={{
              headerShown: false,
            }}
          >
            {user ? (
              <Stack.Screen
                name="HomeTabs"

              >
                {() => <HomeTabs user={user} handleLogout={handleLogout} />}
              </Stack.Screen>
            ) : (
              <>
                <Stack.Screen name="Login" component={LoginScreen} />
                <Stack.Screen name="Register" component={RegisterScreen} />
              </>
            )}
          </Stack.Navigator>
        </NavigationContainer>
      </SafeAreaView>
    </AuthContext.Provider>
  );
}

const styles = StyleSheet.create({
  safeArea: {
    paddingTop: 40,
    flex: 1,
    backgroundColor: "#282560",
  },
});
