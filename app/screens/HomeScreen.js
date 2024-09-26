import { SafeAreaView, Text, View, StyleSheet } from "react-native";
import { useContext } from "react";
import AuthContext from "../contexts/AuthContexts";

export default function App() {
    const { user } = useContext(AuthContext);

    return (
        <SafeAreaView style={styles.container}>
            <View style={styles.content}>
                <Text>Welcome home, {user.name}</Text>
            </View>

        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: 'space-between',
    },
    content: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
        padding: 20,
    },
});
